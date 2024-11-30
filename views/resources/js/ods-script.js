function factorData(data) {
    console.log(data);
    var _data = data.map(function (e, i, a) {
        var prev = a[i - 1];
        var next = a[i + 1];
        if (e === prev && e === next) {
            return '' + e;
        }
        return e;
    }).map(function (e) {
        if (typeof e === "string") {
            return null;
        } else {
            return e;
        }
    });
    console.log(data);
    return _data;
}
function colorFromValue(value, border) {
    var alpha = (1 + Math.log(value)) / 50;
    var color = "purple";
    if (border) {
        alpha += 0.01;
    }
    return Color(color)
            .alpha(alpha)
            .rgbString();
}
function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}
//function factorData(data) {
//    console.log(data);
//   let _data = data.map((e, i, a) => {
//      let prev = a[i - 1];
//      let next = a[i + 1];
//      if (e === prev && e === next) return '' + e;
//      return e;
//   }).map(e => typeof e === 'string' ? null : e);
//   return _data;
//}
