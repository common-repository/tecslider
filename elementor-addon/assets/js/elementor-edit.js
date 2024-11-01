jQuery(document).ready(function($) {
    console.log('imloaded');
    // Function to disable options based on conditions
    function disableElements($el) {
        $el.find('option[value$="_disabled"]').prop('disabled', true);
        $el.find('input[data-setting$="_disabled"]').prop('disabled', true);
    }

    // Trigger the function when the widget form is loaded
    

    elementor.hooks.addAction( 'panel/open_editor/widget', function( panel, model, view ) {
        const widgetType = model.get('widgetType'); // e.g., 'text', 'image', 'button', etc.
        if ('tecslider-elementor-widget' === widgetType) {
            disableElements(panel.$el);
        } else {
            return;
        }
    });
});
