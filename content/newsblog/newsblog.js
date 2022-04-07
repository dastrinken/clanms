//quasi obsolet

function showComments(articleId) {
        $.post("./content/newsblog/newsblog_functions.php",
            {
                command: "showComments",
                id: articleId
            },
            function(data) {
                document.getElementById("content"+articleId).innerHTML = data;
            }
        )
        /*$(function(){
            var simplemde = new SimpleMDE({
                autosave: {
                    enabled: true,
                    delay: 1000,
                },
                hideIcons: ['side-by-side', 'fullscreen']
            });
        }
    )*/     
}

