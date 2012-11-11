<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link href="css/bootstrap.css" rel="stylesheet"/>
        <link href="css/style.css" rel="stylesheet"/>

    </head>
    <body>
        <a href="https://github.com/DonaldDerek/cracktus.git"><img style="position: absolute; top: 0; left: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_left_darkblue_121621.png" alt="Fork me on GitHub"></a>
        <div class="container navbar-wrapper">

            <div class="navbar navbar-inverse">
                <div class="navbar-inner">
                    <a class="brand" href="#">Cracktus <span class="muted small"> Crack the default Blink*</span></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li ><a id="homeC" href="#"><i class="icon-home icon-white icon"></i>Home</a></li>
                            <li><a id="aboutC" href="#about"><i class="icon-lock icon-white icon"></i>About</a></li>

                            <li><a href="#contact"><i class="icon-download icon-white icon"></i>Download</a></li>

                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!-- /.navbar-inner -->
            </div><!-- /.navbar -->

        </div>
        <div id="home" class="container">
            <div class="row">
                <div class="span8">
                    <h1>Hello, World</h1>
                </div>
                <div class="span4">
                    <form class="form-inline" id="signInForm">
                        <label class="control-label" for="inputUsername">save your results by:</label>
                        <input type="text" name="inputUsername" id="inputUsername" placeholder="entering a username">
                        <button type="submit" id="submitUsername" class="btn">Sign in</button>
                    </form>
                    <div id="formResponse"></div>
                </div>

                <div class="span12 center">    
                    <p class="lead">Cracktus is a simple application that can try to crack for you some <strong>BlinkXXXXX</strong>, <strong>SpeedtouchXXXXX</strong> or <strong>ThomsonXXXXX</strong> default passwords. Give it a shot at your own risks.</p>
                    <hr />
                    <a data-toggle="modal" href="#crackForm" class="btn btn-primary btn-large">Give it a shot!</a>
                    <div id="responsePass"><h1><span id="msg"></span><span id="printPass"></span></h1></div>
                </div>
                
                <!-- If user is logged In-->
                <div class="span12">
                    <table style="display: none;" id="prevResults" class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Network Name</th>
                  <th>ESSID</th>
                  <th>Password</th>
                </tr>
              </thead>
              
            </table>
                </div>
            </div>
        </div>

        <!-- Crack Form Modal -->
        <div id="crackForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Cracktus Form" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Enter your ESSID</h3>
            </div>
            <div class="modal-body">
                <p>If the network's name is <strong>BlinkF25BF1</strong> , then you have to enter <strong>F25BF1</strong> as the ESSID. you can also name the network for fast referencing, if your logged in </p>
                <hr />

                <form class="form-horizontal" id="cracktusForm">
                    <div class="control-group">
                        <label class="control-label" for="inputName">Name:</label>
                        <div class="controls">
                            <input type="text" id="inputName" name="inputName" placeholder="name this network">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEssid">*ESSID:</label>
                        <div class="controls">
                            <input type="text" id="inputEssid" name="inputEssid" placeholder="enter essid">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" id ="submitForm" class="btn">Get Password!</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        
        <!-- About-->
        <div id="about" class="container" style="display:none;">
            <div class="span12 center">    
                <p class="lead">GoodDay Leechers  </p>
                <p class="lead">Welcome to your first stop to "borrowing" your nearby neighbors internet connection. Forget word search Bash attempts, finding those rare open networks. Cracktus uses Speetouch, Blink or Thomson code to get the counters preset passcode for you.</p>
                <p class="lead">Just cross ur fingers that they haven't changed the password, and chances are, if they haven't changed the SSID, they don't know how to change the password.</p>
                <p>Happy leeching and good luck finding the fastest connection to "borrow". Please use it at your own discression</p>
            </div>
        </div>

        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#aboutC").click(function(event){
                    $("#home").hide();
                    $("#about").fadeIn();
                    
                });
                $("#homeC").click(function(event){
                    $("#about").hide();
                    $("#home").fadeIn();
                    
                });
                
                var login = false;
                
                
                $("#inputName").attr("disabled", "disabled");
                $("#submitUsername").attr("disabled", "disabled");
               
                $("#inputUsername").change(function(){
                    $("#submitUsername").removeAttr("disabled");
                });
               
                $("#cracktusForm").submit(function(event){
                    
                    var $form = $(this),
                    $inputs = $form.find("input, select, button, textarea"),
                    
                    serializedData = $form.serialize();
                    
                    $inputs.attr("disabled", "disabled");

                    $.ajax({
                        url: "cracktus.php",
                        type: "post",
                        data: serializedData,
                        
                        success: function(response, textStatus, jqXHR){
                            var results = jQuery.parseJSON(response);
                            if(results.err == '0'){
                                $("#printPass").text(results.password)
                                $("#msg").text("and your password is ");  
                            }
                            else{    
                                $("#printPass").text("");
                                $("#msg").text(results.error);
                            }
                              
                        },
                        complete: function(){
                            // enable the inputs
                            $('#inputEssid').removeAttr("disabled");
                            $('#submitForm').removeAttr("disabled");
                            if(login)
                                $('#inputName').removeAttr("disabled");
                        
                            $('#crackForm').modal('hide');
                            $("#inputName").val("");
                            $("#inputEssid").val("");
                            
                            
                        }
                    });

                    // prevent default posting of form
                    event.preventDefault();
                });
                
                $("#signInForm").submit(function(event){
                    
                    var $form = $(this),

                    serializedData = $form.serialize();
                    

                    $.ajax({
                        url: "login.php",
                        type: "post",
                        data: serializedData,
                        
                        success: function(response, textStatus, jqXHR){
                            
                            login = true;
                            var username = $("#inputUsername").val();
                            
                            $("#signInForm").hide();
                            $("#formResponse").show();
                            $("#formResponse").append("<p>Howdy, <strong>"+username+"</strong>!</p>");
                            
                            var data = $.parseJSON(response);
                            var i = 1;
                            $.each(data, function(index, itemData) {
                                
                            $("#prevResults").append("<tr><td>"+i+"</td><td>"+itemData.name+"</td><td>"+itemData.essid+"</td><td>"+itemData.password+"</td></tr>");
                                i++;
                            });
                            if(i > 1)
                                $("#prevResults").show();
                        },
                        complete: function(){
                            $('#inputName').removeAttr("disabled");
                        }
                    });

                    // prevent default posting of form
                    event.preventDefault();
                });
            
            });
        </script>
    </body>
</html>
