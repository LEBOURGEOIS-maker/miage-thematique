var size = 35;
var columns = Array.from(document.getElementsByClassName("clock-column"));
var d, c;
var classList = ["clock-visible", "clock-close", "clock-far", "clock-far", "clock-distant", "clock-distant", "clock-invisible"];
var use24HourClock = true;

function padClock(p, n) {
  return p + ("0" + n).slice(-2);
}

function getClock() {
  d = new Date();
  return [use24HourClock ? d.getHours() : d.getHours() % 12 || 12, d.getMinutes(), d.getSeconds()].reduce(padClock, "");
}

function getClass(n, i2) {
  return classList.find(function (class_, classIndex) {
    return Math.abs(n - i2) === classIndex;
  }) || "";
}

var loop = setInterval(() => {
  c = getClock();

  columns.forEach((ele, i) => {
    let n = +c[i];
    let offset = -n * size;
    ele.style.transform = `translateY(calc(50vh + ${offset}px - ${size /2}px))`;
    Array.from(ele.children).forEach((ele2, i2) => {
      ele2.className = "num " + getClass(n, i2);
    });
  });
}, 200 + Math.E * 10);
