var express = require('express');
var app = express();
var path    = require("path");

app.get('/',function(req,res){
  res.sendFile(path.join(__dirname+'/index.html'));
});

app.use(express.static(path.join(__dirname, 'dist'))); 

var port = process.env.PORT || 3000;
app.listen(port);