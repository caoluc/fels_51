$(function(){
    var urlParams = {}
        , updating = false;
    (window.onpopstate = function () {
        var match,
            pl     = /\+/g,
            search = /([^&=]+)=?([^&]*)/g,
            decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
            query  = window.location.search.substring(1),
            chevron;
        urlParams = {};
        while (match = search.exec(query)){
            urlParams[decode(match[1])] = decode(match[2]);
        }
        urlParams["offset"] = urlParams["offset"] ? parseInt(urlParams["offset"]) : fels_51.defaultOptions.offset;
        urlParams["order"] = urlParams["order"] ? urlParams["order"] : fels_51.defaultOptions.order;
        urlParams["limit"]  = urlParams["limit"] ? parseInt(urlParams["limit"]) : fels_51.defaultOptions.limit;
        urlParams["dir"] = urlParams["dir"] ? urlParams["dir"] : fels_51.defaultOptions.direction;
        chevron = urlParams["dir"] == 'asc' ? '^' : 'v';
        $('span',"#headers").text('');
        $("span",'#'+urlParams["order"]).append(' ' + chevron);
    })();

    var DataModel = function(data) {
        var self = this;

        var ItemModel = function(item){
            var model = this;
            $.each(fels_51.model, function(index){
                model[this.name + '_attributes'] = {};

                if (typeof(this.column) == 'undefined') {
                    model[this.name] = ko.observable(item[this.name]);
                } else {
                    model[this.name] = ko.observable(item[this.column]);
                }
                
                if( this.editable ){
                    model[this.name + '_edit'] = ko.observable(model[this.name]());
                }
                if( this['options'] ){
                    model[this.name + '_options'] = this['options'];
                }
            });
            model.editing = ko.observable(false);
            model.edit = function(){
                this.editing(true);
            };
            model.detail = function(){
                location.href = fels_51.generateItemUrl(location.pathname,model.id());
            };
            model.cancel = function(){
                if (this.id() == ''){
                    self.data.remove(model);
                } else {
                    $.each(fels_51.model, function(index){
                        if( this.editable ){
                            model[this.name + '_edit'](model[this.name]());
                        }
                    });
                    this.editing(false);
                }
            };
            model.save = function(button){
                var url = location.pathname,
                    method = "POST",
                    data = {};
                    $.each(fels_51.model, function(index){
                        var field_name = this.name;
                        if (typeof(this.column) != 'undefined') {
                            field_name = this.column;
                        }
                        if( this.editable ){
                            data[field_name] = model[this.name + '_edit']();
                        }
                        else{
                            data[field_name] = model[this.name]();
                        }
                    });
                var l = Ladda.create(button);
                l.start();
                if( model.id() > 0 ){
                    url = fels_51.generateItemUrl(location.pathname,model.id());
                    method = "PUT";
                    data['id'] = model.id();
                }
                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    error: function(xhr, error) {
                        console.log(xhr.status);
                        if(xhr.status == 400) {
                            fels_51.displayMessage(xhr.responseJSON.message, 'warning');
                        }
                        l.stop();
                    },
                    success: function(response) {
                        $.each(fels_51.model, function(index){
                            if( this.editable ){
                                model[this.name]( model[this.name + '_edit']() );
                            }
                            if( this['options'] ){
                                model[this.name + '_options'] = this['options'];
                            }
                        });
                        model.id(response.id);
                        model.editing(false);
                        l.stop();
                    }
                });

            };
            model.remove = function(button){
                if( model.id() > 0 ) {
                    if (confirm('Are you sure you want to delete item :  ' + (model.name ? model.name() : model.id()))) {
                        var url = fels_51.generateItemUrl(location.pathname,model.id()),
                            l = Ladda.create(button);
                        l.start();
                        $.ajax({
                            url: url,
                            method: "DELETE",
                            data: null,
                            error: function(xhr, error) {
                                console.log(error);
                                l.stop();
                            },
                            success: function(response) {
                                self.data.remove(model);
                                l.stop();
                            }
                        });
                    }
                }else{
                    self.data.remove(model);
                }
            };
        };

        self.data = ko.observableArray(data);
        self.limit = ko.observable(urlParams["limit"]);
        self.update = function(params, history){
            var data = $.param({
                order  : params["order"],
                offset : params["offset"],
                dir    : params["dir"],
                limit  : self.limit(),
                format : "json"
            });
            $.ajax({
                url: location.pathname,
                method: 'GET',
                contentType: false,
                processData: false,
                data: data,
                error: function (xhr, error) {
                    console.log(error);
                },
                success: function (response) {
                    updating = true;
                    if (history) {
                        History.pushState({
                                offset: response["offset"],
                                order: response["order"],
                                limit: response["limit"],
                                dir: response["dir"]
                            }, fels_51.title + " | Admin | fels_51",
                                "?order=" + response["order"]
                                + "&offset=" + response["offset"]
                                + "&limit=" + response["limit"]
                                + "&dir=" + response["dir"]);
                    }
                    urlParams["offset"] = response["offset"];
                    urlParams["limit"] = response["limit"];
                    urlParams["dir"] = response["dir"];
                    urlParams["order"] = response["order"];
                    var items = [];
                    $.each(response['data'], function (index) {
                        items.push(new ItemModel(this));
                    });
                    self.data(items);
                    updating = false;
                }
            });
        };
        self.add = function() {
            var data = {};
            $.each(fels_51.model, function(index){
                data[this.name] = "";
            });
            var item = new ItemModel(data);
            item.editing(true);
            self.data.unshift(item);
        };
        self.saveall = function(button) {
            for (var i = 0; i < self.data().length; i++) {
                if(self.data()[i].editing()) {
                    self.data()[i].save(button);
                }
            }
        };
        self.addNew = function(item) {
            $.each(fels_51.model, function(index){
                data[this.name] = "";
            });
            data['authors'] = ko.utils.unwrapObservable(item.authors);
            data['color_categories'] = ko.utils.unwrapObservable(item.color_categories);
            var newItem = new ItemModel(data);
            newItem.editing(true);
            self.data.unshift(newItem);
        };
        self.next = function(){
            var params = urlParams;
            params['offset'] = parseInt(params['offset']) + parseInt(self.limit());
            self.update(params, true);
            return false;
        };
        self.changeLimit = function(){
            var params = urlParams;
            params['limit'] = self.limit();
            self.update(params, true);
            return false;
        };
        self.sort = function(e,event){
            var params = urlParams;
            if (params['order'] == event.target.id) {
                if (params['dir'] == 'asc') {
                    params['dir'] = 'dsc';
                } else {
                    params['dir'] = 'asc';
                }
            } else {
                params['order'] = event.target.id;
            }
            self.update(params, true);
            return false;
        };
        self.prev = function(){
            var params = urlParams;
            params['offset'] = params['offset'] - self.limit();
            if( params['offset'] < 0 ){
                params['offset'] = 0;
            }
            self.update(params, true);
            return false;
        };

        self.filters = fels_51.filters;

        if (self.filters) {
            self.activeFilter = ko.observable(self.filters[0].filter);
            self.setActiveFilter = function(model,event){
                self.activeFilter(model.filter);
            };

            self.filteredData = ko.computed(function(){
                if(self.activeFilter()){
                    return ko.utils.arrayFilter(self.data(), self.activeFilter());
                } else {
                    return self.data();
                }
            });
        }

    };

    var viewModel = new DataModel([]);
    ko.applyBindings(viewModel);

    History.Adapter.bind(window,'statechange',function(){
        if( !updating ){
            var state = History.getState();
            viewModel.update(state.data, false);
        }
    });

    viewModel.update(urlParams, false);
});
