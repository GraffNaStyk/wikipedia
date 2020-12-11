document.addEventListener('click', function (e) {
  var down_class = ' dir-d '
  var up_class = ' dir-u '
  var regex_dir = / dir-(u|d) /
  var regex_table = /\bsortable\b/
  var element = e.target

  function reclassify(element, dir) {
    element.className = element.className.replace(regex_dir, '') + dir
  }

  if (element.nodeName === 'TH') {
    try {
      // var table = element.offsetParent; // Fails with positioned table elements
      // this is the only way to make really, really sure. A few more bytes though... >:
      var table = element.parentNode.parentNode.parentNode
      if (regex_table.test(table.className)) {
        var column_index
        var tr = element.parentNode
        var nodes = tr.cells

        // reset thead cells and get column index
        for (var i = 0; i < nodes.length; i++) {
          if (nodes[i] === element) {
            column_index = i
          } else {
            reclassify(nodes[i], '')
          }
        }

        var dir = down_class

        // check if we're sorting up or down, and update the css accordingly
        if (element.className.indexOf(down_class) !== -1) {
          dir = up_class
        }

        reclassify(element, dir)

        // extract all table rows, so the sorting can start.
        var org_tbody = table.tBodies[0]

        // get the array rows in an array, so we can sort them...
        var rows = [].slice.call(org_tbody.rows, 0)

        var reverse = dir === up_class

        // sort them using custom built in array sort.
        rows.sort(function (a, b) {
          var x = (reverse ? a : b).cells[column_index].innerText
          var y = (reverse ? b : a).cells[column_index].innerText
          return isNaN(x - y) ? x.localeCompare(y) : x - y
        })

        // Make a clone without contents
        var clone_tbody = org_tbody.cloneNode()

        // Build a sorted table body and replace the old one.
        while (rows.length) {
          clone_tbody.appendChild(rows.splice(0, 1)[0])
        }

        // And finally insert the end result
        table.replaceChild(clone_tbody, org_tbody)
      }
    } catch (error) {
      // console.log(error)
    }
  }
})
