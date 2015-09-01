$(document).ready(function() {
    ///////////////////////////
    // Parsers configuration //
    ///////////////////////////

	$.tablesorter.addParser({
        // set a unique id
        id: 'data',
        is: function(s) {
                // return false so this parser is not auto detected 
                return false;
        },
        format: function(s, table, cell) {
            return ($(cell).find('*[data-sorter]').length > 0) ? $(cell).find('*[data-sorter]').attr('data-sorter') : s;
        },
        // set type, either numeric or text 
        type: 'text'
    });

    /////////////////
    // Init config //
    /////////////////

    $.tablesorter.themes.bootstrap = {
        iconSortAsc  : 'fa fa-angle-up', // class name added to icon when column has ascending sort
    	iconSortDesc : 'fa fa-angle-down', // class name added to icon when column has descending sort
    };

    $('.tablesorter').tablesorter({
        theme : "bootstrap",
        headerTemplate : '{content} {icon}',
        widgets : [ "uitheme"]
    });
});