$(function () {
    var ItemModel = function (data) {
        console.log(fels_51.data.item);
        var model = this;
        var item = fels_51.data['item'];
        $.each(fels_51.model, function(index){
            model[this.name] = ko.observable(item[this.name]);
            if( this.editable ){
                model[this.name + '_edit'] = ko.observable(item[this.name]);
            }
        });
        model.prevId = ko.observable(fels_51.data.prev_id);
        model.nextId = ko.observable(fels_51.data.next_id);
        model.editing = ko.observable(false);
        model.edit = function () {
            this.editing(true);
        };
        model.cancel = function () {
            $.each(fels_51.model, function(index){
                if( this.editable ){
                    model[this.name + '_edit'](model[this.name]());
                }
            });
            this.editing(false);
        };
        model.save = function (button) {
            var url = location.pathname,
                method = "PUT",
                data = {};
            $.each(fels_51.model, function(index){
                if( this.editable ){
                    data[this.name] = model[this.name + '_edit']();
                }
            });
            var l = Ladda.create(button);
            l.start();
            $.ajax({
                url: url,
                method: method,
                data: data,
                error: function (xhr, error) {
                    fels_51.displayMessage(xhr.responseJSON.message,'warning');
                    l.stop();
                },
                success: function (response) {
                    $.each(fels_51.model, function(index){
                        model[this.name](response[this.name]);
                        if( this.editable ){
                            model[this.name + '_edit'](response[this.name]);
                        }
                    });
                    model.editing(false);
                    l.stop();
                }
            });
        };
        model.prev = function () {
            if (model.prevId() > 0) {
                model.update(model.prevId())
            }
            return false;
        };
        model.next = function () {
            if (model.nextId() > 0) {
                model.update(model.nextId())
            }
            return false;
        };
        model.update = function (id) {
            var url = fels_51.replaceItemId(location.pathname, id);
            var jsonUrl = url + '?format=json';
            $.ajax({
                url: jsonUrl,
                method: 'GET',
                contentType: false,
                processData: false,
                data: data,
                error: function (xhr, error) {
                    console.log(error);
                },
                success: function (response) {
                    if (history) {
                        History.pushState({
                                id: id
                            }, "Admin | fels_51",
                            url);
                    }
                    model.nextId(response['next_id']);
                    model.prevId(response['prev_id']);
                    $.each(fels_51.model, function(index){
                        model[this.name](response.item[this.name]);
                        if( this.editable ){
                            model[this.name + '_edit'](response.item[this.name]);
                        }
                    });

                    model.editing(false);
                }
            });

        };
    };
    var viewModel = new ItemModel(fels_51.model);
    ko.applyBindings(viewModel);
});