const blogs = require('./controllers/blogs.controllers');
const events = require('./controllers/events.controllers');

module.exports = function(app) {
  app
    .get('/api/blogs', blogs.getAll)
    .get('/api/blogs/:id', blogs.getOne)
    .post('/api/blogs', blogs.createNew)
    .put('/api/blogs/:id', blogs.updateOne)
    .delete('/api/blogs/:id', blogs.deleteOne)

    .get('/api/events', events.getAll)
    .get('/api/events/:id', events.getOne)
    .post('/api/events', events.createNew)
    .put('/api/events/:id', events.updateOne)
    .delete('/api/events/:id', events.deleteOne)
}

