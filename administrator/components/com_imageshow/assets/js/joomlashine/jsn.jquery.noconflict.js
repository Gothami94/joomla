var JoomlaShine = {};
JoomlaShine.jQuery = window.jQuery.noConflict();
if (typeof(oldJquery) != 'undefined') {
	JoomlaShine.jQueryBackup = oldJquery;
}