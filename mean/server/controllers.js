const Blog = require('./models');


module.exports = {

  getAll: (req, res) => {
    Blog.find({})
      .then(data => res.json(data))
      .catch(err => res.json(err))
  },

  getOne: (req, res) => {
    const ID = req.params.id;
    Blog.find({_id: ID})
      .then(data => res.json(data))
      .catch(err => res.json(err))
  },

  createNew: (req, res) => {
    const DATA = req.body;
    
    Blog.create(DATA)
      .then(newObject => res.json(newObject))
      .catch(err => res.json(err));
  }
}
