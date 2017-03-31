// was originally outside document ready handler
//var $ = jQuery.noConflict();

// vote for question
function voteQ(id, how) {
    var $ = jQuery.noConflict();

    $.get('/qa/voteQ/?id='+id+'&how='+how, function (data) {
        $('#qvotes').text(data);
    });

    /*
    if (how=="plus") {
        $('#voteQplus').removeClass(); 
        $('#voteQplus').addClass('pluss');
        $('#voteQminus').removeClass(); 
        $('#voteQminus').addClass('minus');
    }
    if (how=="minus") {
        $('#voteQplus').removeClass(); 
        $('#voteQplus').addClass('plus');
        $('#voteQminus').removeClass(); 
        $('#voteQminus').addClass('minuss');
    }
    */
    return false;
}

// vote for answer
function voteA(id, how) {
    var $ = jQuery.noConflict();
    $.get('/qa/voteA/?id='+id+'&how='+how, function (data) {
        $('#avotes'+id).text(data);
    });

    if (how=="plus") {
        $('#voteA'+id+'plus').removeClass(); 
        $('#voteA'+id+'plus').addClass('pluss');
        $('#voteA'+id+'minus').removeClass(); 
        $('#voteA'+id+'minus').addClass('minus');
    }
    if (how=="minus") {
        $('#voteA'+id+'plus').removeClass(); 
        $('#voteA'+id+'plus').addClass('plus');
        $('#voteA'+id+'minus').removeClass(); 
        $('#voteA'+id+'minus').addClass('minuss');
    }
    return false;
}
