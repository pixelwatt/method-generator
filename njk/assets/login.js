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
            	['#4B7D62', '#4BFD9F'],
                ['#585858', '#AEAEAE']

            ],
            transitionSpeed: 7000
        }
    }
});{% endblock %}