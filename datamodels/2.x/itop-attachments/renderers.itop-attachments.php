<?php
/**
 * Copyright (C) 2013-2021 Combodo SARL
 *
 * This file is part of iTop.
 *
 * iTop is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * iTop is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 */

/**
 * Attachments rendering for iTop console.
 *
 * For the user portal, see \Combodo\iTop\Renderer\Bootstrap\FieldRenderer\BsFileUploadFieldRenderer
 */

use Combodo\iTop\Application\UI\Base\Component\Alert\Alert;
use Combodo\iTop\Application\UI\Base\Component\Button\Button;
use Combodo\iTop\Application\UI\Base\Component\Button\ButtonUIBlockFactory;
use Combodo\iTop\Application\UI\Base\Component\DataTable\DataTableUIBlockFactory;
use Combodo\iTop\Application\UI\Base\Component\Input\FileSelect\FileSelectUIBlockFactory;
use Combodo\iTop\Application\UI\Base\Component\Panel\PanelUIBlockFactory;
use Combodo\iTop\Renderer\BlockRenderer;

define('ATTACHMENT_DOWNLOAD_URL', 'pages/ajax.document.php?operation=download_document&class=Attachment&field=contents&id=');
define('ATTACHMENTS_RENDERER', 'TableDetailsAttachmentsRenderer');


/**
 * For now this factory is just a helper to instanciate the renderer
 */
class AttachmentsRendererFactory
{
	/**
	 * @param \WebPage $oPage
	 * @param string $sObjClass class name of the objects holding the attachments
	 * @param int $iObjKey key of the objects holding the attachments
	 * @param string $sTransactionId CSRF token
	 *
	 * @return \AbstractAttachmentsRenderer rendering impl
	 */
	public static function GetInstance($oPage, $sObjClass, $iObjKey, $sTransactionId)
	{
		$sRendererClass = ATTACHMENTS_RENDERER;
		/** @var \AbstractAttachmentsRenderer $oAttachmentsRenderer */
		$oAttachmentsRenderer = new $sRendererClass($oPage, $sObjClass, $iObjKey, $sTransactionId);

		return $oAttachmentsRenderer;
	}
}


/**
 * Common code for attachment rendering
 *
 * On each attachment you'll need to have :
 *
 *  * an id on the attachment container (see GetAttachmentContainerId)
 *  * an input hidden inside the container (see GetAttachmentHiddenInput)
 *
 * @see \AttachmentPlugIn::DisplayAttachments()
 */
abstract class AbstractAttachmentsRenderer
{
	/**
	 * If size (in bits) is above this, then we will display a file icon instead of preview. Overloaded by 'icon_preview_max_size' conf param
	 */
	const DEFAULT_MAX_SIZE_FOR_PREVIEW = 500000;

	/**
	 * Attachments list container HTML id, that must be generated in {@link RenderEditAttachmentsList}
	 *
	 * @since 2.7.0-2 N°2968 ajax buttons (on especially the #attachment_plugin hidden input) should not be refreshed
	 *             so we are refreshing only the content of this container
	 */
	const ATTACHMENTS_LIST_CONTAINER_ID = 'AttachmentsListContainer';

	/** @var \WebPage */
	protected $oPage;
	/**
	 * @var string CSRF token, must be provided cause when getting content from AJAX we need the one from the original page, not the
	 *     ajaxpage
	 */
	private $sTransactionId;
	/** @var string */
	protected $sObjClass;
	/** @var int */
	protected $iObjKey;
	/** @var \DBObjectSet */
	protected $oTempAttachmentsSet;
	/** @var \DBObjectSet */
	protected $oAttachmentsSet;

	/**
	 * @param \WebPage $oPage
	 * @param string $sObjClass class name of the objects holding the attachments
	 * @param int $iObjKey key of the objects holding the attachments
	 * @param string $sTransactionId CSRF token
	 *
	 * @throws \OQLException
	 */
	public function __construct(\WebPage $oPage, $sObjClass, $iObjKey, $sTransactionId)
	{
		$this->oPage = $oPage;
		$this->sObjClass = $sObjClass;
		$this->iObjKey = $iObjKey;
		$this->sTransactionId = $sTransactionId;

		$oSearch = DBObjectSearch::FromOQL('SELECT Attachment WHERE item_class = :class AND item_id = :item_id');
		$this->oAttachmentsSet = new DBObjectSet($oSearch, array(), array('class' => $sObjClass, 'item_id' => $iObjKey));

		$oSearchTemp = DBObjectSearch::FromOQL('SELECT Attachment WHERE temp_id = :temp_id');
		$this->oTempAttachmentsSet = new DBObjectSet($oSearchTemp, array(), array('temp_id' => $this->sTransactionId));
	}

	/**
	 * @return \DBObjectSet
	 */
	public function GetTempAttachmentsSet()
	{
		return $this->oTempAttachmentsSet;
	}

	/**
	 * @return \DBObjectSet
	 */
	public function GetAttachmentsSet()
	{
		return $this->oAttachmentsSet;
	}

	public function GetAttachmentsCount()
	{
		return $this->GetAttachmentsSet()->Count() + $this->GetTempAttachmentsSet()->Count();
	}

	/**
	 * Can be overriden to change display order, but must generate an HTML container of ID {@link ATTACHMENTS_LIST_CONTAINER_ID} for JS refresh.
	 *
	 * @param int[] $aAttachmentsDeleted Attachments id that should be deleted after form submission
	 * 
	 * @param int[] $aAttachmentsDisabled Attachments id that should be Disabled after form submission
	 * 
	 * @return void will print using {@link oPage}
	 */
	public function RenderEditAttachmentsList($aAttachmentsDeleted = array(), $aAttachmentsDisabled = array())
	{
		$this->AddUploadButton();

		$this->oPage->add('<div id="'.self::ATTACHMENTS_LIST_CONTAINER_ID.'">');
		$this->AddAttachmentsListContent(true, $aAttachmentsDeleted, $aAttachmentsDisabled);
		$this->oPage->add('</div>');
	}

	/**
	 * Generates the attachments list content
	 *
	 * @param bool $bWithDeleteButton
	 * @param array $aAttachmentsDeleted
	 * @param bool $bWithDisableButton
	 * @param array $aAttachmentsDisabled
	 *
	 * @throws \ArchivedObjectException
	 * @throws \CoreException
	 * @throws \CoreUnexpectedValue
	 * @throws \MySQLException
	 */
	abstract public function AddAttachmentsListContent($bWithDeleteButton, $bWithDisableButton, $aAttachmentsDeleted = array(), $aAttachmentsDisabled = array());

	public function RenderViewAttachmentsList()
	{
		$this->AddAttachmentsListContent(false, array());
	}

	protected function AddUploadButton()
	{
		$sClass = $this->sObjClass;
		$sId = $this->iObjKey;
		$iMaxUploadInBytes = AttachmentPlugIn::GetMaxUploadSize();
		$sMaxUploadLabel = AttachmentPlugIn::GetMaxUpload();
		$sFileTooBigLabel = Dict::Format('Attachments:Error:FileTooLarge', $sMaxUploadLabel);
		$sFileTooBigLabelForJS = addslashes($sFileTooBigLabel);
		$this->oPage->add('<div id="ibo-attachment--upload-file">');
		$this->oPage->add('<div id="ibo-attachment--upload-file--upload-button-container">');
		$this->oPage->add(Dict::S('Attachments:AddAttachment'));
		$oAddButton = FileSelectUIBlockFactory::MakeStandard('file', 'file');
		$oAddButton->SetShowFilename(false);
		$this->oPage->AddUiBlock($oAddButton);
		$this->oPage->add('<span style="display:none;" id="attachment_loading"><img src="../images/indicator.gif"></span> '.$sMaxUploadLabel);
		$this->oPage->add('</div>');
		$this->oPage->add('<div class="ibo-attachment--upload-file--drop-zone-hint ibo-svg-illustration--container">');
		$this->oPage->add(file_get_contents(APPROOT.'images/illustrations/undraw_upload.svg'));
		$this->oPage->add(Dict::S('UI:Attachments:DropYourFileHint').'</div>');
		

		$this->oPage->add_linked_script(utils::GetAbsoluteUrlAppRoot().'js/jquery.iframe-transport.js');
		$this->oPage->add_linked_script(utils::GetAbsoluteUrlAppRoot().'js/jquery.fileupload.js');

		$this->oPage->add_ready_script(
			<<<JS
	function RefreshAttachmentsDisplay(dataUpload)
	{
		var sContentNode = '#AttachmentsListContainer',
			aAttachmentsDeletedHiddenInputs = $('#AttachmentsListContainer table>tbody>tr[id^="display_attachment_"]>td input[name="removed_attachments[]"]'),
			aAttachmentsDeletedIds = aAttachmentsDeletedHiddenInputs.map(function() { return $(this).val() }).toArray();
			//^ customization cfac for disable attachement
			aAttachmentsDisabledHiddenInputs = $('#AttachmentsListContainer table>tbody>tr[id^="display_attachment_"]>td input[name="disabled_attachments[]"]'),
			aAttachmentsDisabledIds = aAttachmentsDisabledHiddenInputs.map(function() { return $(this).val() }).toArray();
			//^ customization cfac for disable attachement
		$(sContentNode).block();
		$.post(GetAbsoluteUrlModulesRoot()+'itop-attachments/ajax.itop-attachment.php',
		   { 
		   	    operation: 'refresh_attachments_render', 
		   	    objclass: '$sClass', 
		   	    objkey: $sId, 
		   	    temp_id: '$this->sTransactionId', 
		   	    edit_mode: 1, 
		   	    attachments_deleted: aAttachmentsDeletedIds,
				//^ customization cfac for disable attachement
				attachments_disabled: aAttachmentsDisabledIds
				//^ customization cfac for disable attachement
	        },
		   function(data) {
			 $(sContentNode).html(data);
			 $(sContentNode).unblock();
			 
			 $('#attachment_plugin').trigger('add_attachment', [dataUpload.result.att_id, dataUpload.result.msg, false]);
			}
		 )
	}
	
    $('#file').fileupload({
		url: GetAbsoluteUrlModulesRoot()+'itop-attachments/ajax.itop-attachment.php',
		formData: { operation: 'add', temp_id: '$this->sTransactionId', obj_class: '$sClass' },
        dataType: 'json',
		pasteZone: null, // Don't accept files via Chrome's copy/paste
        done: function(e, data) {
			if(typeof(data.result.error) != 'undefined')
			{
				if(data.result.error !== '')
				{
					alert(data.result.error);
					return;
				}
			}
			RefreshAttachmentsDisplay(data);
		},
	    send: function(e, data){
	        // Don't send attachment if size is greater than PHP post_max_size, otherwise it will break the request and all its parameters (\$_REQUEST, \$_POST, ...)
	        // Note: We loop on the files as the data structures is an array but in this case, we only upload 1 file at a time.
	        var iTotalSizeInBytes = 0;
	        for(var i = 0; i < data.files.length; i++)
	        {
	            iTotalSizeInBytes += data.files[i].size;
	        }
	        
	        if(iTotalSizeInBytes > $iMaxUploadInBytes)
	        {
	            alert('$sFileTooBigLabelForJS');
		        return false;
		    }
	    },
        start: function() {
        	$('#attachment_loading').show();
		},
        stop: function() {
        	$('#attachment_loading').hide();
		}
    });

  $(document).on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
  })
  
	$(document).bind('dragover', function (e) {
		var bFiles = false;
		if (e.dataTransfer && e.dataTransfer.types)
		{
			for (var i = 0; i < e.dataTransfer.types.length; i++)
			{
				if (e.dataTransfer.types[i] == "application/x-moz-nativeimage")
				{
					bFiles = false; // mozilla contains "Files" in the types list when dragging images inside the page, but it also contains "application/x-moz-nativeimage" before
					break;
				}
				
				if (e.dataTransfer.types[i] == "Files")
				{
					bFiles = true;
					break;
				}
			}
		}
	
		if (!bFiles) return; // Not dragging files
		
		window.dropZone = $('#file').closest('.ibo-tab');
		if (!CombodoGlobalToolbox.IsElementVisibleToTheUser(dropZone[0]))
		{
			// Hidden, but inside an inactive tab? Highlight the tab
			var sTabId = dropZone.closest('.ibo-tab-container--tab-container').attr('aria-labelledby');
			dropZone = $('#'+sTabId).closest('li');
		}

        window.dropZone.addClass('ibo-drag-in');
	});
  
  // Counter used to fix chrome firing dragenter/dragleave on each $(document) child it encounter
  window.dropZoneCnt = 0;
  
  $(document).on('dragenter', function(ev) {
        ev.preventDefault(); // needed for IE
        window.dropZoneCnt++;
    });
    
	$(document).bind('dragend dragleave drop', function(event){
        window.dropZoneCnt--;
		if(window.dropZone && window.dropZoneCnt === 0){
			window.dropZone.removeClass('ibo-drag-in');
			window.dropZone = null;
		}
	});
	
	// check if the attachments are used by inline images
	window.setTimeout( function() {
		$('.attachment a').each(function() {
			var sUrl = $(this).attr('href');
			if($('img[src="'+sUrl+'"]').length > 0)
			{
				$(this).addClass('image-in-use').find('img').wrap('<div class="image-in-use-wrapper" style="position:relative;display:inline-block;"></div>');
			}
		});
		$('.htmlEditor').each(function() {
			var oEditor = $(this).ckeditorGet();
			var sHtml = oEditor.getData();
			var jElement = $('<div/>').html(sHtml).contents();
			jElement.find('img').each(function() {
				var sSrc = $(this).attr('src');
				$('.attachment a[href="'+sSrc+'"]').parent().addClass('image-in-use').find('img').wrap('<div class="image-in-use-wrapper" style="position:relative;display:inline-block;"></div>');
			});
		});
		$('.image-in-use-wrapper').append('<div style="position:absolute;top:0;left:0;"><img src="../images/transp-lock.png"></div>');
	}, 200 );
JS
		);
		$this->oPage->p('<input type="hidden" id="attachment_plugin" name="attachment_plugin"/>');
		$this->oPage->add('</div>');
	}

	protected function GetAttachmentContainerId($iAttachmentId)
	{
		return 'display_attachment_'.$iAttachmentId;
	}

	protected function GetAttachmentHiddenInput($iAttachmentId, $bIsDeletedAttachment, $bIsDisabledAttachment)
	{
		$sInputNamePrefix = $bIsDeletedAttachment ? 'removed_' : '';
		//^ customization cfac for disable attachement
		$sInputNamePrefixDisable = $bIsDisabledAttachment ? 'disabled_' : '';
		//^ end customization cfac

		return '<input id="attachment_'.$iAttachmentId.'" type="hidden" name="'.$sInputNamePrefix.'attachments[]" value="'.$iAttachmentId.'">
		<input id="attachment_'.$iAttachmentId.'" type="hidden" name="'.$sInputNamePrefixDisable.'attachments[]" value="'.$iAttachmentId.'">';
	}

	protected function GetDeleteAttachmentButton($iAttId)
	{
		$oButton = ButtonUIBlockFactory::MakeIconAction('fas fa-trash', Dict::S('Attachments:DeleteBtn'),
			'',
			Dict::S('Attachments:DeleteBtn'),
			false,
			"btn_remove_".$iAttId);
		$oButton->AddCSSClass('btn_hidden')
			->SetOnClickJsCode("RemoveAttachment(".$iAttId.");")
			->SetColor(Button::ENUM_COLOR_SCHEME_DESTRUCTIVE);
		
		return $oButton;
	}

	//^ customization cfac for disable attachement
	protected function GetDisableAttachmentButton($iAttId)
	{
		$oButton = ButtonUIBlockFactory::MakeIconAction('fas fa-calculator', Dict::S('Attachments:DisableBtn'),
			'',
			Dict::S('Attachments:DisableBtn'),
			false,
			"btn_disable_".$iAttId);
		$oButton->AddCSSClass('btn_hidden')
			->SetOnClickJsCode("DisableAttachment(".$iAttId.");")
			->SetColor(Button::ENUM_COLOR_SCHEME_VALIDATION);
		
		return $oButton;
	}
	//^ end customization cfac

	protected function GetDeleteAttachmentJs()
	{
		return <<<JS
	function RemoveAttachment(att_id)
	{
		var bDelete = true;
		if ($('#display_attachment_'+att_id).hasClass('image-in-use'))
		{
				bDelete = window.confirm('This image is used in a description. Delete it anyway?');
		}
		if (bDelete)
		{
			$('#attachment_'+att_id).attr('name', 'removed_attachments[]');
			$('#display_attachment_'+att_id).hide();
			$('#attachment_plugin').trigger('remove_attachment', [att_id]);
		}
		return false; // Do not submit the form !
	}
JS;
	}

	//^ customization cfac for disable attachement
	protected function GetDisableAttachmentJs()
	{
		return <<<JS
	function DisableAttachment(att_id)
	{
		var bDisable = true;
		if ($('#display_attachment_'+att_id).hasClass('image-in-use'))
		{
				bDisable = window.confirm('This image is used in a description. Disable it anyway?');
		}
		if (bDisable)
		{
			$('#attachment_'+att_id).attr('name', 'disabled_attachments[]');
			$('#display_attachment_'+att_id).hide();
			$('#attachment_plugin').trigger('disable_attachment', [att_id]);
		}
		return false; // Do not submit the form !
	}
JS;
	}
	//^ end customization cfac
}


/**
 * Class TableDetailsAttachmentsRenderer
 */
class TableDetailsAttachmentsRenderer extends AbstractAttachmentsRenderer
{
	public function AddAttachmentsListContent($bWithDeleteButton, $bWithDisableButton, $aAttachmentsDeleted = array(), $aAttachmentsDisabled = array())
	{
		if ($this->GetAttachmentsCount() === 0)
		{
			$this->oPage->add(Dict::S('Attachments:NoAttachment'));

			return;
		}


		$sThumbnail = Dict::S('Attachments:File:Thumbnail');
		$sFileName = Dict::S('Attachments:File:Name');
		$sFileSize = Dict::S('Attachments:File:Size');
		$sFileDate = Dict::S('Attachments:File:Date');
		$sFileUploader = Dict::S('Attachments:File:Uploader');
		$sFileType = Dict::S('Attachments:File:MimeType');
		//^ customization cfac for disable attachement
		$sFileStatusComp = Dict::S('Attachments:File:status');
		$sFileTypeAttachment = Dict::S('Attachments:File:type_attachment');
		$sFileNumJournal = Dict::S('Attachments:File:num_journal');
		$sFileDateComp = Dict::S('Attachments:File:date_comptabilisation');
		$sFileNumPiece = Dict::S('Attachments:File:num_piece');
		//^ end customization cfac

		if ($bWithDeleteButton)
		{
			$this->oPage->add_script($this->GetDeleteAttachmentJs());
		}

		//^ customization cfac for disable attachement
		if ($bWithDisableButton)
		{
			$this->oPage->add_script($this->GetDisableAttachmentJs());
		}
		//^ end customization cfac

		$bIsEven = false;
		$aAttachmentsDate = AttachmentsHelper::GetAttachmentsDateAddedFromDb($this->sObjClass, $this->iObjKey);
		$aData = array();
		while ($oAttachment = $this->oAttachmentsSet->Fetch())
		{
			$bIsEven = ($bIsEven) ? false : true;
			$aData[] = $this->AddAttachmentsTableLine($bWithDeleteButton, $bWithDisableButton, $bIsEven, $oAttachment, $aAttachmentsDate, $aAttachmentsDeleted, $aAttachmentsDisabled);
		}
		while ($oTempAttachment = $this->oTempAttachmentsSet->Fetch())
		{
			$bIsEven = ($bIsEven) ? false : true;
			$aData[] = $this->AddAttachmentsTableLine($bWithDeleteButton, $bWithDisableButton, $bIsEven, $oTempAttachment, $aAttachmentsDate, $aAttachmentsDeleted, $aAttachmentsDisabled);
		}

		$aAttribs = array(
			'icon' => array('label' => $sThumbnail, 'description' => $sThumbnail),
			'filename' => array('label' => $sFileName, 'description' => $sFileName),
			'formatted-size' => array('label' => $sFileSize, 'description' => $sFileSize),
			'upload-date' => array('label' => $sFileDate, 'description' => $sFileDate),
			'uploader' => array('label' => $sFileUploader, 'description' => $sFileUploader),
			'type' => array('label' => $sFileType, 'description' => $sFileType),
			//^ customization cfac for disable attachement
			'status-comp' => array('label' => $sFileStatusComp, 'description' => $sFileStatusComp),
			'num-journal' => array('label' => $sFileNumJournal, 'description' => $sFileNumJournal),
			'date-comptabilisation' => array('label' => $sFileDateComp, 'description' => $sFileDateComp),
			'num-piece' => array('label' => $sFileNumPiece, 'description' => $sFileNumPiece),
			//^ end customization cfac
		);

		if ($bWithDeleteButton) {
			$aAttribs['delete'] = array('label' => '', 'description' => '');
		}

		//^ customization cfac for disable attachement
		if ($bWithDisableButton) {
			$aAttribs['disable'] = array('label' => '', 'description' => '');
		}
		//^ end customization cfac

		$oPanel = PanelUIBlockFactory::MakeNeutral('');
		$oPanel->AddCSSClass('ibo-datatable-panel');
		$oAttachmentTableBlock = DataTableUIBlockFactory::MakeForStaticData('', $aAttribs, $aData);
		$oAttachmentTableBlock->AddCSSClass('ibo-attachment--datatable');
		$oPanel->AddSubBlock($oAttachmentTableBlock);

		$this->oPage->AddUiBlock($oPanel);

		$sTableId = $oAttachmentTableBlock->GetId();

		foreach ($aData as $aAtt){
			$sJS = $aAtt['js'];
			$this->oPage->add_ready_script(
				<<<JS
$('#$sTableId').on('init.dt draw.dt', function(){
	$sJS
});
JS
		);
		}
		
	}

	/**
	 * @param bool $bWithDeleteButton
	 * @param bool $bWithDisableButton
	 * @param bool $bIsEven
	 * @param \DBObject $oAttachment
	 * @param array $aAttachmentsDate
	 * @param int[] $aAttachmentsDeleted
	 * @param int[] $aAttachmentsDisable
	 *
	 * @return array
	 * @throws \ArchivedObjectException
	 * @throws \CoreException
	 * @throws \Exception
	 */
	private function AddAttachmentsTableLine($bWithDeleteButton, $bWithDisableButton, $bIsEven, $oAttachment, $aAttachmentsDate, $aAttachmentsDeleted, $aAttachmentsDisabled)
	{
		$iAttachmentId = $oAttachment->GetKey();

		$bIsDeletedAttachment = false;
		if (in_array($iAttachmentId, $aAttachmentsDeleted, true))
		{
			$bIsDeletedAttachment = true;
		}

		//^ customization cfac for disable attachement
		$bIsDisabledAttachment = false;
		if (in_array($iAttachmentId, $aAttachmentsDisabled, true))
		{
			$bIsDisabledAttachment = true;
		}
		//^ end customization cfac

		/** @var \ormDocument $oDoc */
		$oDoc = $oAttachment->Get('contents');

		$sDocDownloadUrl = utils::GetAbsoluteUrlAppRoot().ATTACHMENT_DOWNLOAD_URL.$iAttachmentId;
		$sFileName = utils::HtmlEntities($oDoc->GetFileName());
		$sTrId = $this->GetAttachmentContainerId($iAttachmentId);
		$sAttachmentMeta = $this->GetAttachmentHiddenInput($iAttachmentId, $bIsDeletedAttachment, $bIsDisabledAttachment);
		$iFileSize = $oDoc->GetSize();
		$sFileFormattedSize = $oDoc->GetFormattedSize();
		$bIsTempAttachment = ($oAttachment->Get('item_id') === 0);
		$sAttachmentDateFormatted = '';
		if (!$bIsTempAttachment)
		{
			$sAttachmentDate = $oAttachment->Get('creation_date');
			if (empty($sAttachmentDate) && array_key_exists($iAttachmentId, $aAttachmentsDate))
			{
				$sAttachmentDate = $aAttachmentsDate[$iAttachmentId];
			}
			$oAttachmentDate = DateTime::createFromFormat(AttributeDateTime::GetInternalFormat(), $sAttachmentDate);
			$sAttachmentDateFormatted = AttributeDateTime::GetFormat()->Format($oAttachmentDate);
		}
		
		//^ customization cfac for disable attachement
		$sStatusComp = $oAttachment->Get('status_comp');
		if ($sStatusComp==true)
		{
			//show table comptabilité  with $sShowTableComp = true ==>show all <tr>
			$sStatusBtnLabelValid = Dict::S('Portal:Button:ValidStatut');
			$sStatusCompCell = '<input id="status_id_portal_user" style="font-size: 10px; background-color: #357a38; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%;" type="button" class="btn btn-xs btn-primary;" value="'.$sStatusBtnLabelValid.'" disabled>';
		} else {
			$sStatusBtnLabelNonValid = Dict::S('Portal:Button:NonValidStatut');
			$sStatusCompCell = '<input id="status_id_portal_user" style="font-size: 10px; background-color: #660000; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%;" type="button" class="btn btn-xs btn-primary" value="'.$sStatusBtnLabelNonValid.'" disabled>';
		}

		$sTypeAttachment = $oAttachment->Get('type_attachment');
		if ($sTypeAttachment!=null)
		{
			if ($sTypeAttachment='attachment_achat') {
				$sTypeBtnLabelAchat = Dict::S('Portal:Button:TypeAchat');
				$sTypeAttachmentCompCell = '<input id="type_attachment_'.$iAttachmentId.'_row" style="font-size: 10px; background-color: #357a38; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%;" type="button" class="btn btn-xs btn-primary;" value="'.$sTypeBtnLabelAchat.'" disabled>';
			} else if ($sTypeAttachment='attachment_vente') {
				$sTypeBtnLabelVente = Dict::S('Portal:Button:TypeVente');
				$sTypeAttachmentCompCell = '<input id="type_attachment_'.$iAttachmentId.'_row" style="font-size: 10px; background-color: #357a38; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%;" type="button" class="btn btn-xs btn-primary;" value="'.$sTypeBtnLabelVente.'" disabled>';
			} else if ($sTypeAttachment='attachment_banque') {
				$sTypeBtnLabelBanque = Dict::S('Portal:Button:TypeBanque');
				$sTypeAttachmentCompCell = '<input id="type_attachment_'.$iAttachmentId.'_row" style="font-size: 10px; background-color: #357a38; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%;" type="button" class="btn btn-xs btn-primary;" value="'.$sTypeBtnLabelBanque.'" disabled>';
			} else if ($sTypeAttachment='attachment_other') {
				$sTypeBtnLabelOther = Dict::S('Portal:Button:TypeOther');
				$sTypeAttachmentCompCell = '<input id="type_attachment_'.$iAttachmentId.'_row" style="font-size: 10px; background-color: #357a38; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%;" type="button" class="btn btn-xs btn-primary;" value="'.$sTypeBtnLabelOther.'" disabled>';
			}	
		} else {
			$sStatusBtnLabelNonValid = Dict::S('Portal:Button:TypeUndefined');
			$sTypeAttachmentCompCell = '<input id="status_id_portal_user" style="font-size: 10px; background-color: #660000; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%;" type="button" class="btn btn-xs btn-primary" value="'.$sStatusBtnLabelNonValid.'" disabled>';
		}

		$sNumJournal = $oAttachment->Get('num_journal');
		if ($sNumJournal==true)
		{
			$sNumJournalBtnLabelValid = Dict::S('Portal:Button:ValidStatut');
			$sNumJournalCell = '<p id="status_id_portal_user" style="text-shadow: -5px 2px 1px RGBa(0,0,160,0.3), 0px 0px 10px RGBa(160,0,0,0.8); text-align: center; padding: 17px;">'.$sNumJournalBtnLabelValid.'</p>';
		} else {
			$sNumJournalBtnLabelNonValid = Dict::S('Portal:Button:NonValidStatut');
			$sNumJournalCell = '<p id="status_id_portal_user" style="text-shadow: -5px 2px 1px RGBa(0,0,160,0.3), 0px 0px 10px RGBa(160,0,0,0.8); text-align: center; padding: 17px;" class="p2">'.$sNumJournalBtnLabelNonValid.'</p>';
		}

		$sDateComp = $oAttachment->Get('date_comptabilisation');
		if ($sDateComp==true)
		{
			$sDateCompBtnLabelValid = Dict::S('Portal:Button:ValidStatut');
			$sDateCompCell = '<input id="status_id_portal_user" style="font-size: 10px; background-color: #357a38; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%; text-align: center; padding: 17px;" type="button" class="btn btn-xs btn-primary;" value="'.$sDateCompBtnLabelValid.'" disabled>';
		} else {
			$sDateCompBtnLabelNonValid = Dict::S('Portal:Button:NonValidStatut');
			$sDateCompCell = '<input id="status_id_portal_user" style="font-size: 10px; background-color: #660000; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%; text-align: center; padding: 17px;" type="button" class="btn btn-xs btn-primary" value="'.$sDateCompBtnLabelNonValid.'" disabled>';
		}

		$sNumPiece = $oAttachment->Get('num_piece');
		if ($sNumPiece==true)
		{
			$sNumPieceBtnLabelValid = Dict::S('Portal:Button:ValidStatut');
			$sNumPieceCompCell = '<input id="status_id_portal_user" style="font-size: 10px; background-color: #357a38; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%; text-align: center; padding: 17px;" type="button" class="btn btn-xs btn-primary;" value="'.$sNumPieceBtnLabelValid.'" disabled>';
		} else {
			$sNumPieceBtnLabelNonValid = Dict::S('Portal:Button:NonValidStatut');
			$sNumPieceCompCell = '<input id="status_id_portal_user" style="font-size: 10px; background-color: #660000; width: 104px; height: 28px; border: none; color: white; padding: 8px 13px; text-align: center; text-decoration: none; display: inline-block; margin: 1px 1px; cursor: pointer; border-radius: 25% 10%; text-align: center; padding: 17px;" type="button" class="btn btn-xs btn-primary" value="'.$sNumPieceBtnLabelNonValid.'" disabled>';
		}
		//^ end customization cfac

		$sAttachmentUploader = $oAttachment->Get('contact_id_friendlyname');
		$sAttachmentUploaderForHtml = utils::HtmlEntities($sAttachmentUploader);

		$sFileType = $oDoc->GetMimeType();

		$sAttachmentThumbUrl = utils::GetAbsoluteUrlAppRoot().AttachmentPlugIn::GetFileIcon($sFileName);
		$sIconClass = '';
		$iMaxWidth = MetaModel::GetModuleSetting('itop-attachments', 'preview_max_width', 290);
		$iMaxSizeForPreview = MetaModel::GetModuleSetting('itop-attachments', 'icon_preview_max_size', self::DEFAULT_MAX_SIZE_FOR_PREVIEW);

		$sPreviewNotAvailable = Dict::S('Attachments:PreviewNotAvailable');
		$sPreviewMarkup = $sPreviewNotAvailable;
		if ($oDoc->IsPreviewAvailable())
		{
			$sIconClass = ' preview';
			if ($oDoc->GetSize() <= $iMaxSizeForPreview)
			{
				$sAttachmentThumbUrl = $sDocDownloadUrl;
			}
			$sPreviewMarkup = utils::HtmlEntities('<img src="'.$sDocDownloadUrl.'" style="max-width: '.$iMaxWidth.'"/>');
		}

		
		$aAttachmentLine = array(
			'@id' => $sTrId,
			'@meta' => 'data-file-type="'.utils::HtmlEntities($sFileType).'" data-file-size-raw="'.utils::HtmlEntities($iFileSize).'" data-file-size-formatted="'.utils::HtmlEntities($sFileFormattedSize).'" data-file-uploader="'.utils::HtmlEntities($sAttachmentUploader).'"',
			'icon' => '<a href="'.$sDocDownloadUrl.'" target="_blank" class="trigger-preview '.$sIconClass.'"><img class="ibo-attachment--datatable--icon-preview '.$sIconClass.'" data-tooltip-content="'.$sPreviewMarkup.'" data-tooltip-html-enabled="true" src="'.$sAttachmentThumbUrl.'"></a>',
			'filename' => '<a href="'.$sDocDownloadUrl.'" target="_blank" class="$sIconClass">'.$sFileName.'</a>'.$sAttachmentMeta,
			'formatted-size' => $sFileFormattedSize,
			'upload-date' => $sAttachmentDateFormatted,
			'uploader' => $sAttachmentUploaderForHtml,
			'type' => $sFileType,
			//^ customization cfac for disable attachement
			'status-comp' => $sStatusCompCell,
			'type-attachment' => $sTypeAttachmentCompCell,
			'num-journal' => $sNumJournalCell,
			'date-comptabilisation' => $sDateCompCell,
			'num-piece' => $sNumPieceCompCell,
			//^ end customization cfac
			'js' => '',
		);

		if ($bIsDeletedAttachment) {
			$aAttachmentLine['@class'] = 'ibo-is-hidden';
		}

		if ($bWithDeleteButton)
		{
			$sDeleteButton = $this->GetDeleteAttachmentButton($iAttachmentId);

			$oBlockRenderer = new BlockRenderer($sDeleteButton);
			$aAttachmentLine['js'] .= $oBlockRenderer->RenderJsInline($sDeleteButton::ENUM_JS_TYPE_ON_INIT);
			$aAttachmentLine['delete'] = $oBlockRenderer->RenderHtml();
		}

		//^ customization cfac for disable attachement
		if ($bIsDisabledAttachment) {
			$aAttachmentLine['@class'] = 'ibo-is-hidden';
		}

		if ($bWithDisableButton)
		{
			$sDisableButton = $this->GetDisableAttachmentButton($iAttachmentId);

			$oBlockRenderer = new BlockRenderer($sDisableButton);
			$aAttachmentLine['js'] .= $oBlockRenderer->RenderJsInline($sDisableButton::ENUM_JS_TYPE_ON_INIT);
			$aAttachmentLine['disable'] = $oBlockRenderer->RenderHtml();
		}
		//^ end customization cfac
		return  $aAttachmentLine;
	}
}
