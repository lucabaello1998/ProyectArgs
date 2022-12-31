fetch('../../../corpo/corpo2/php/get_depositoseriado.php')
.then(function(response) {
    return response.json();
})
.then(function(json) {
    
    var array = JSON.parse(JSON.stringify(json));
    console.log(array);
});