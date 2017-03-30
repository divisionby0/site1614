// was originally outside document ready handler 

$(document).ready(function ($){
    function voteQ(id, how) {
        $.get('/qa/voteQ/?id='+id+'&how='+how, function (data) {
            $('#qvotes').text(data);
        });

        if (how=="plus") {
            $('#voteQplus').removeClass(); $('#voteQplus').addClass('pluss');
            $('#voteQminus').removeClass(); $('#voteQminus').addClass('minus');
        }
        if (how=="minus") {
            $('#voteQplus').removeClass(); $('#voteQplus').addClass('plus');
            $('#voteQminus').removeClass(); $('#voteQminus').addClass('minuss');
        }

        return false;
    }
    function voteA(id, how) {
        $.get('/qa/voteA/?id='+id+'&how='+how, function (data) {
            $('#avotes'+id).text(data);
        });

        if (how=="plus") {
            $('#voteA'+id+'plus').removeClass(); $('#voteA'+id+'plus').addClass('pluss');
            $('#voteA'+id+'minus').removeClass(); $('#voteA'+id+'minus').addClass('minus');
        }
        if (how=="minus") {
            $('#voteA'+id+'plus').removeClass(); $('#voteA'+id+'plus').addClass('plus');
            $('#voteA'+id+'minus').removeClass(); $('#voteA'+id+'minus').addClass('minuss');
        }

        return false;
    }
});
