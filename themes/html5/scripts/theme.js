$(document).ready(function() {
   $('a[rel*=lightbox]').lightBox({
	overlayBgColor: '#000',
	overlayOpacity: 0.8,
	imageLoading: 'images/icons/lightbox/lightbox-btn-loading.gif',
	imageBtnClose: 'images/icons/lightbox/lightbox-btn-close.gif',
	imageBtnPrev: 'images/icons/lightbox/lightbox-btn-prev.gif',
	imageBtnNext: 'images/icons/lightbox/lightbox-btn-next.gif',
	containerResizeSpeed: 350,
	txtImage: 'Image',
	txtOf: '/'
   });
});