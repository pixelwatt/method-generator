{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}var granimInstance = new Granim({
    element: '#bg-canvas',
    direction: 'top-bottom',
    isPausedWhenNotInView: true,
    image : {
        source: theme.template_dir + '{{globals.custom_login_bg}}',
        blendingMode: '{{globals.custom_login_bg_blending}}',
        stretchMode: [ 'stretch-if-smaller','stretch-if-smaller']
    },
    states : {
        "default-state": {
            gradients: [
            	['#dcc9d7', '#f5cfc5'],
            	['#ffaf89', '#925d7a']
            ],
            transitionSpeed: 7000
        }
    }
});{% endblock %}