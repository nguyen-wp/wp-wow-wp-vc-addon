
function wowMakeID(length) {
    var result           = [];
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result.push(characters.charAt(Math.floor(Math.random() *  charactersLength)));
   }
   return result.join('');
}

window.addEventListener('load', function () {
    if (document.getElementById("nectar-metabox-fullscreen-rows")) {
        var wowAdminCss = '.wpb-content-layouts-container .wpb-content-layouts li:hover[data-element*=wow-vc-] .icon-wow-vc-adminicon { filter: invert(1) brightness(100); opacity: 1; } .wpb-content-layouts-container .wpb-content-layouts li:hover[data-element*=wow-vc-]:after { filter: invert(1) brightness(100); }';
        var wowAdminhead = document.head || document.getElementsByTagName('head')[0];
        var wowAdminstyle = document.createElement('style');
        wowAdminhead.appendChild(wowAdminstyle);
        if (wowAdminstyle.styleSheet) {
            wowAdminstyle.styleSheet.cssText = wowAdminCss;
        } else {
            wowAdminstyle.appendChild(document.createTextNode(wowAdminCss));
        }
    }
})
jQuery( document ).ready(function() {
    var value = jQuery('.wow_vc_admin_autogen_id input');
    if(value.length && value.val().length < 1){
        value.val(wowMakeID(10))
    }
});
jQuery(function() {
    var value = jQuery('.wow_vc_admin_autogen_id input');
    if(value.length && value.val().length < 1){
        value.val(wowMakeID(10))
    }
});

jQuery('#vc_ui-panel-edit-element').bind('DOMSubtreeModified', function(e) {
    var value = jQuery('.wow_vc_admin_autogen_id input');
    if(value.length && value.val().length < 1){
        value.val(wowMakeID(10))
    }
});