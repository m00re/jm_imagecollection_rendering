<?php
namespace JensMittag\JmImagecollectionRendering\Controller;

/**
 * Plugin 'imagecollection' to render filecollections in RTE
 *
 * @author	Jens Mittag <kontakt@jensmittag.de>
 */
class ImageCollectionController extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {

	public $prefixId = 'tx_jmimagecollectionrendering_controller_tag';

	// Path to this script relative to the extension dir.
	public $scriptRelPath = 'Classes/Controller/ImageCollectionController.php';
	public $extKey = 'jm_imagecollection_rendering';
	public $conf = array();

	/**
	 * cObj object
	 *
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	public $cObj;

	/**
	 * The current view, as resolved by resolveView()
	 *
	 * @var \TYPO3\CMS\Extbase\Mvc\View\ViewInterface
	 * @api
	 */
	protected $view = NULL;

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function render($content, $conf) {

		$this->conf = $conf;
		$uid = intval($content);

		// First get the file collection by the id given
		$collectionRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileCollectionRepository');
		$collection = $collectionRepository->findByUid($uid);

		$this->view = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
		$renderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
		$renderer->loadJquery();

		// Fetch the records
		$collection->loadContents();
		$files = $collection->getItems();

		$images = array();

		foreach ($files as $fileObject) {
			if ($fileObject->getType() == 2) {
				// Calculate the width of the current picture w.r.t. the current row height
				$properties = $fileObject->getProperties();

				$image = array();
				$image['ratio'] = $properties['width'] / $properties['height'];
				$image['url'] = $fileObject->getPublicUrl();
				$image['fileObj'] = $fileObject;
				$image['title'] = $fileObject->getTitle();
				$image['clickEnlargeWidth'] = $this->conf['settings.']['maxImageHeight'] * $image['ratio'];
				if ($image['ratio'] > 1.0) {
					$image['class'] = "landscape r" . number_format($image['ratio'], 1, "", "");
				} else if ($image['ratio'] < 1.0) {
					$image['class'] =  "portrait r" . number_format($image['ratio'], 1, "", "");
				} else {
					$image['class'] =  "square";
				}

				// Add the image to the current row
				$images[] = $image;
			}
		}

		// Use Fluid to render the image collection
		$templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($this->conf['view.']['templateRootPath']);
		$templatePathAndFilename = $templateRootPath . 'ImageCollection.html';
		$this->view->setTemplatePathAndFilename($templatePathAndFilename);
		$this->view->assign('images', $images);
		$this->view->assign('settings', $this->conf['settings.']);
		$this->view->assign('uid', $uid);

		$content = $this->view->render();

		// Add Javascript file
		$portfoliojs = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($this->conf['settings.']['portfolioJs']);
		$renderer->addJsFooterFile(\TYPO3\CMS\Core\Utility\PathUtility::getAbsoluteWebPath($portfoliojs),
			'text/javascript', /* compress? */ false, false, '',
			/* excludeFromConcatenation? */ true, '|', /* async? */ false);//, /* integrity? */ 'sha256-b07457d8f5ce2d11be2d0b53a6f44416c5a1315bb60099e6cf1a66a2099d76d3');

		// Add CSS style
		$portfolioCss = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($conf['settings.']['portfolioCss']);
		$renderer->addCssFile(\TYPO3\CMS\Core\Utility\PathUtility::getAbsoluteWebPath($portfolioCss),
			'stylesheet', 'all', '', false, false, '', true);

		// Strip all white spaces at the beginning and the end of each line, and
		// eliminate all empty lines. This is necessary, else RTE text transformations
		// create a <p class=""bodytext">...</p> for each of them.
		return preg_replace('/^\s+|\n|\r|\s+$/m', '', $content);
	}

}

?>
