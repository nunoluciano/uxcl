function get_thumb_elfinder(name, file) {
	return file.tmb.replace(rootUrl+'/', '');
}
function get_thumb_gnavi(name, file) {
	return file.simg.replace(rootUrl+'/', '') + '/' + name;
}
function get_thumb_mailbbs(name) {
	name = name.replace(/\.[^.]+$/, '');
	return moduleUrl.replace(rootUrl+'/', '') + '/mailbbs/imgs/s/' + name + '.jpg';
}
function get_thumb_photos(name, file) {
	return file.simg.replace(rootUrl+'/', '') + '/' + name;
}
function get_thumb_xelfinder(name, file) {
	if (file.url.match(/\?/)) {
		file.tmb = file.url.replace('=view', '=tmb&s=_tmbsize_');
	} else {
		file.tmb = file.url.replace('/view/', '/tmb/_tmbsize_/');
	}
	return file.tmb.replace(rootUrl+'/', '');
}
