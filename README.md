# Responsive Image Collection Rendering for Typo3

This is a Typo3-Extension that overrides the default rendering style of image collections with a responsive method
featuring a Javascript-disabled mode and a Javascript-enabled mode. If the browser has disabled Javascript, images
are aligned as a grid of squares using CSS flexbox. The number of images per row is alternating to add some irregularity,
images are cropped using CSS, and a mouseover effect reveals the full picture.

If Javascript is enabled, the image collection is rendered as a dynamic slider, i.e. all images are aligned in a row,
whereas navigation is performed via left and right buttons.

In addition, a new Tag `<imagecollection>uid</imagecollection>` is provided that allows the inclusion of image collections
from within RTE.

## Dependencies

- Typo3 v7.x
- Extbase
- Fluid
- Bootstrap CSS / Glyphicon Halflings

## Installation & Configuration

1. Install the extension as you normally do it.
2. Add the Typoscript template `Responsive Image Collections` to your frontend Typoscript template.
3. Optionally, add the PageTS template `EXT:jm_imagecollection_rendering - Enable Tag Processing in RTE` to your PageTS
   configuration in case you want to make use of the `<imagecollection>uid</imagecollection>` Tag.

The plugin comes with only one configuration option: the maximum height of the shown images. The setting
`plugin.tx_jmimagecollectionrendering.settings.maxImageHeight` defaults to `800` downsizes all images with
a larger height automatically.

## TODOs

- Implement a RTE plugin that simplifies the selection of a file collection (instead of inserting the tag with the proper
  file collection uid manually)
- Add touch/swipe support in slider mode.
