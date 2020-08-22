{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php
	get_header();
	$layout = new {{globals.code_layoutclass}};
	echo $layout->build_page( '', true );
	get_footer();
{% endblock %}