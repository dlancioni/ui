let func = [
  "function hi1() {alert(1);}",
  "function calc(a,b) {alert(a+b);}",
  "document.getElementById('div1').innerText = 'maria'",
]

var se = document.createElement('script');
se.setAttribute('type', 'text/javascript');

for (let i=0; i<3; i++) {
  se.appendChild(document.createTextNode(func[i]));
}
document.getElementsByTagName('head').item(0).appendChild(se);
