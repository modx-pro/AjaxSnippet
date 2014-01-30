--------------------
AjaxSnippet
--------------------
Author: Vasiliy Naumkin <bezumkin@yandex.ru>
--------------------

Simple component for MODX Revolution, that allows you to run any snippet through ajax.

Call AjaxSnippet at any page

[[!AjaxSnippet?snippet=`pdoResources`&parents=`0`]]


You can specify any parameters for end snippet:

[[!AjaxSnippet?
	&snippet=`pdoResources`
	&parents=`0`
	&tpl=`@INLINE <p>[[+idx]]. <a href="[[+link]]">[[+pagetitle]]</a></p>`
	&useWeblinkUrl=`1`
	&etc=`...`
]]


You can use jQuery event "as_complete" for custom functionality:

$(document).on('as_complete', document, function(e,d) {
	console.log(d);
})


--------------------
Feel free to suggest ideas/improvements/bugs on GitHub:
http://github.com/bezumkin/AjaxSnippet/issues