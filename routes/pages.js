var express = require('express');
var router = express.Router();
const db = require('../db');

/* GET users listing. */
router.get('/:slug', function(req, res, next) {
  const slug = req.params['slug'];
  db.query('SELECT * FROM pages WHERE slug = $1', [slug], (err, result) => {
    if (err) {
      console.log(err)
      res.render('pages/not_found');
    } else {
      res.render('pages/index', { page: result.rows[0] });
    }
  });
});

module.exports = router;
