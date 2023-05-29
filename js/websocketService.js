function websocketService(callback) {
  this.ws = null;
  this.callback = callback;
  /* this.connection(); */
}
websocketService.prototype.connection = function () {

  // const isLocalhost = window.location.hostname === "localhost";
  // const url = `ws://${window.location.hostname}${isLocalhost ? ':3000' : ''}`;

  const url = "wss://yocreoquesipuedohacerlo.com/";

  if (!this.ws || (this.ws && ![0, 1].includes(this.ws.readyState))) {
    this.ws = new WebSocket(url);
    // ESCUCHAMOS LOS EVENTOS
    this.ws.addEventListener('open', (e) => {
      console.log("ws open");
    });
    this.ws.addEventListener("message", (e) => {
      console.log('e.data', e.data);
      this.callback(e);
      // this.mySubject$.emit(e.data);
    });
    this.ws.addEventListener('close', (e) => {
      if (e.code == 106 || !e.wasClean) {
        console.log('ws close');
        this.connection(url);
      } else {
        //console.log("event, ws : ", e, this.ws);
      }
    });
    this.ws.addEventListener('error', (e) => {
      console.log('e :>> ', e);
    });
  }
}

websocketService.prototype.send = function (data) {
  if (this.ws && this.ws.readyState === this.ws.OPEN) {
    this.ws.send(data);
  } else {
    this.ws.addEventListener('open', (e) => {
      this.ws.send(data);
    });
  }

}


function notification(message) {
  Notification.requestPermission().then((result) => {
    let n = new Notification("The Med Universe", {
      icon: '../images/med-isfrgb.png',
      body: message
    });
  });
}