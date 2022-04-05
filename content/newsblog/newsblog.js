function showComments(articleId) {
    $.post("./content/newsblog/newsblog_functions.php",
        {
            command: "showComments",
            id: articleId
        },
        function(data) {
            document.getElementById("content"+articleId).innerHTML = data;
        })
}

