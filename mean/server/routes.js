const controllers = require('./controllers');

module.exports = function(app) {
  app
    .get('/api/blogs', controllers.getAll)
    .get('/api/blog/:id', controllers.getOne)
    .post('/api/blogs', controllers.createNew)
    .put('/api/blogs/:id', controllers.updateOne)
    .delete('/api/blogs/:id', controllers.deleteOne)
    .all("*", (req,res,next) => {
      res.sendFile(path.resolve("./public/dist/public/index.html"))
    })

}

