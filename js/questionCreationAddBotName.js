$(document).ready(function ($){
    var botNameContainer = $("#botNameContainer");
    var botName = botNameContainer.text();
    $("#questionAuthorName").append($('<option>', { value : "88888" }).text(botName));
});
