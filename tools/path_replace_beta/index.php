<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Database Update</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-git2.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
    <style>
        html { width: 100vw; height: 100vh; }
        *{
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -o-user-select: none;
            user-select: none;
        }

        .loading, .loading *{
            cursor:wait;
        }

        body {
            width: 100%;
            max-width: 1000px;
            margin: 12px auto;
            font-family: 'Roboto', sans-serif;
            background: #e1e1e1;
        }

        h1 {
            text-transform: capitalize;
            margin: auto 15px 15px;
            color: #333;
        }

        input[type="text"] {
            width: calc(100% - 48px);
            border: 1px solid #ccc;
            border-radius: 4px;
            height: 37px;
            padding: 7px;
            margin: 3px 15px;
        }

        button {
            height: 38px;
            width: 180px;
            border-radius: 4px;
            margin: 2px 15px;
            color: #fff;
            transition:all 0.3s ease;
        }
        button#submit{
            background-color: #337ab7;
            border-color: #2e6da4;
        }

        button#submit:hover{
            background-color: #286090;
            border-color: #204d74;
        }

        button#run{    
            background-color: #5bc0de;
            border-color: #46b8da;
        }
        button#run:hover{
            background-color: #31b0d5;
            border-color: #269abc;
        }

        button#submit::before{content:'Check';}
        button#run::before{content:'Run';}

        #result_box{
            margin: 0px 15px;
            padding-top:3px;
            padding-bottom:10px;
            display:block;            
        }

        #result_box > *{
            display:block;
            margin:0px 5px;
            cursor:pointer;

            transition:all 0.3s ease;
        }

        #result_box > *:hover{
            background:#aaa;
        }

        #result_box + *{
            display:none;
        }

        #result_box.open + *{
            display:block;
        }

        #get_database{
            cursor: pointer;
            text-decoration: none;
        }

        #gopage{
            background-color: #d9534f;
            border-color: #d43f3a;
            float:right;
        }

        p{
            margin:7px 15px;
        }

    </style>
</head>

<body>

    <h1>Database Update (Developer) <small>v2</small></h1>
    <input name="old-path" type="text" placeholder="Old text" value ="localhost" />
    <div id = "result_box"></div>
    <input name="new-path" type="text" placeholder="New Text" value ="" />

    <button id="submit"></button>
    <button id="gopage">Preview Page</button>
    <br/>
    <p>Get your database backup from Admin Panel > Tools > Backup/Restore</p>
    <br/>
    <br/>

</body>
<script type="text/javascript">
    $(window).load(function(){
        var url = window.location.hostname+window.location.pathname.toString();
        url = url.substring(0, url.lastIndexOf("/") - 5);
        url = url.replace("/tools","");
        url = url.replace("/path_replace","");
        $("input[name='new-path']").val(url);
        $("#gopage").click(function(){
            window.open("../../");
        });
    });
    $("#submit").mouseup(function(){ check_list(); });

    function check_list(){
        var old_path = $("input[name='old-path']").val();
        var new_path = $("input[name='new-path']").val();
        if (old_path && (typeof old_path !== 'undefined')) {
            $("html").addClass("loading");
            $.ajax({
                url: "update-check.php",
                data: {
                    "old_path": old_path,
                    "new_path": new_path
                },
                type: 'post',
                dataType: 'json',
                success: function(respond) {                    
                    if(respond){
                        var html = "";
                        for(var i = 0 ; i < respond.length ; i++){
                            var sim = respond[i];
                            var query = "UPDATE `"+sim['table']+"` SET `"+sim['column']+"` = REPLACE(`"+sim['column']+"`,";
                                // \'"+new_path+"\') missing part; for accepting new value (last change); format : 'localhost/eco','localhost/eco/gg')
            if(sim['serialize']) {
                query = sim['table'] + "@" + sim['column'];
            }

            html += '<label><input type = "checkbox" name = "added_query[]" value ="'+query+'" />';
            html += "Result found in Table `"; 
            html += sim['table'];                     
            html += "` under column `"; 
            html += sim['column']; 
            if(sim['serialize']) {
                html += "` which is serialized</label>" 
            }else{
              html += "` which is not serialized</label>";   
          } 
      }

      if(html){
        $("#result_box").html(html).addClass("open");
        $("#result_box input").click(function(){
            check_atleast();
        });
    }
    $("html").removeClass("loading");
}
}
});
}
}
function check_atleast(){
    if($("#run").length){$("#run").attr({"id":"submit"});}
    $("#result_box input").each(function(){
        if($(this).is(":checked")){
            $("#submit").off("mouseup");
            $("#submit").attr({"id":"run"});
        }
    });
    if($("#run").length){
        $("#run").mouseup(function(){dyrun();});
    }else{
        $("#submit").off("mouseup");
        $("#submit").on("mouseup",function(){
            check_list();
        });
    }
}
function dyrun(){
    //alert("Running"); // Working
    var new_path = $("input[name='new-path']").val();
    var old_path = $("input[name='old-path']").val();
    var marked = $("input[name=\'added_query[]\']:checked").map(function(){return $(this).val();}).get();
    $.ajax({
        url:"run-update.php",
        data: {
            "old_path": old_path,
            "marked":marked,
            "new_path": new_path
        },
        type: 'post',
        dataType: 'json',
        success: function(respond) {
            var output = respond;
            if(output){
                $("#result_box").slideUp(300,function(){
                    $(this).removeClass("open").empty();
                    if($("#run").length){$("#run").attr({"id":"submit"});}
                    $("#submit").off("mouseup");
                    $("#submit").on("mouseup",function(){
                        check_list();
                    });
                    alert("There is a total of "+output+" row changed");
                });
            }else{
                alert("Nothing has changed");
            }
        }  
    });
    $("html").removeClass("loading");
}

</script>
</html>
