var express = require('express');
var app = express();
var path    = require("path");

app.get('/',function(req,res){
  res.sendFile(path.join(__dirname+'/index.html'));
});

app.get('/css/',function(req,res){
  res.sendFile(path.join(__dirname+'/dist/css/style.min.css'));
});

app.get('/js/',function(req,res){
  res.sendFile(path.join(__dirname+'/dist/js/script.min.js'));
});

app.use(express.static('dist'));

var port = process.env.PORT || 3000;
app.listen(port);