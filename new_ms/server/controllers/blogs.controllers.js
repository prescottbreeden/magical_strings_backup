const Blogs = require('../models/blogs.model');


module.exports = {

  getAll: (req, res) => {
    Blogs.find({})
      .then(data => res.json(data))
      .catch(err => res.json(err))
  },

  getOne: (req, res) => {
    const ID = req.params.id;
    Blogs.find({_id: ID})
      .then(data => res.json(data))
      .catch(err => res.json(err))
  },

  createNew: (req, res) => {
    const DATA = req.body;
    
    Blogs.create(DATA)
      .then(newObject => res.json(newObject))
      .catch(err => res.json(err));
  }
}
