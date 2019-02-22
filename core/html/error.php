<!DOCTYPE html>  
<html>  
<head>  
  <meta charset="UTF-8">  
  <title>ERROR</title>  
  <style>
    .container {color:#eee}
    .left {float:left;width:30%;text-align:center;margin-right:20px;}
    .right {padding: 100px 0 100px 200px}
    .title {font-size: 4rem;padding:100px;}
    .title-WARNING {background-color:darkorange}
    .title-FATAL {background-color:tomato}
    .recommend {background-color:slategrey;padding:50px;}
    .recommend a {color:#eee}
    .message {background-color:cadetblue;padding:50px 300px;font-size: 1.8rem}
    .trace {background-color:darkgray;padding:30px 300px;color:#fff}
  </style>
</head>  
<body>  
  <div class="container">
    <div class="left">
      <div class="title title-<?=$title?>"><?=$title?></div>
      <div class="recommend"><a href="javascript:goBack()">返回首页</a></div> 
    </div>
    <div class="right">
      <div class="message"><?=$message?></div>
      <div class="trace"><?=$error_html?></div>
    </div>
  </div>
</body>  
</html>  
