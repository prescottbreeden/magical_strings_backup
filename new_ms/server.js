const express = require('express');
const bp = require('body-parser');
const path = require('path');
const PORT = 8080;
const app = express();

app.use(bp.json());
app.use(express.static(path.join(__dirname, './public/dist/public')));
app.all("*", (req,res,next) => {
  res.sendFile(path.resolve("./public/dist/public/index.html"))
})
app.listen(PORT, ()=> {
  console.log("Listening on port: " + PORT);
})


