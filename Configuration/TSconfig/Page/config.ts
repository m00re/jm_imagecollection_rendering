# RTE button settings: allow User plugin
RTE.default.showButtons := addToList(user)
RTE.default.hideButtons := removeFromList(user)

# allowed/denied tags
RTE.default.proc.allowTags := addToList(imagecollection)
RTE.default.proc.allowTagsOutside := addToList(imagecollection)
RTE.default.proc.entryHTMLparser_db.allowTags < RTE.default.proc.allowTags
lib.parseFunc_RTE.allowTags := addToList(imagecollection) 
lib.parseFunc.allowTags := addToList(imagecollection) 
RTE.default.proc.dontConvBRtoParagraph = 1
