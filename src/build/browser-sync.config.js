module.exports = {
	proxy: 'hesis.local/',
	host: 'hesis.local',
	open: 'external',
	notify: false,
	files: ['./css/*.min.css', './js/*.min.js', './**/*.php'],
};
