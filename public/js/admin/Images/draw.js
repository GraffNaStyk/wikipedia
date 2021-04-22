import * as App from '../../app.js';

App.on('submit', '.tui', (e) => {
  e.preventDefault();
  let name = document.querySelector('input[name="name"]');
  let data = {
    img: imageEditor.toDataURL(),
    name: name.value
  };

  App.post({data: data, url:'images/store'})
  .then(res => res.json())
  .then(res => {
      if (res.ok) {
        window.history.back();
      } else {
        App.throwCustomMessage(res, '.right-panel');
      }
  });
} )
