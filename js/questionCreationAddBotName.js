$(document).ready(function ($){
    var botNameContainer = $("#botNameContainer");
    var botName = botNameContainer.text();
    $("#questionAuthorName").append($('<option>', { value : "1" }).text(botName));
});
