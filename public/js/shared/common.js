fels_51.generateItemUrl = function(urlBase, id) {
    if( urlBase.substr(-1) === '/'){
        return urlBase + id;
    }else{
        return urlBase + '/' + id;
    }
};

fels_51.replaceItemId = function(urlBase, id) {
    var pathElements = urlBase.split("/");
    if( urlBase.substr(-1) === '/') {
        pathElements.pop();
    }
    if( pathElements.length > 0){
        pathElements[pathElements.length-1] = id;
    }
    return pathElements.join('/');
};

fels_51.displayMessage = function(message, type){
    type = typeof type !== 'undefined' ? type : 'info';
    $.growl({
            message: message,
            type: type
        },
        {
            placement: {
                from: "top",
                align: "center"
            },
            offset: 100,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            }
        });
}