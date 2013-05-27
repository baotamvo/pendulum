define(['spin','jquery',
    'blockUI','fullCalendar','jTinyMCE',
    'pNotify','bootstrap/bootstrap-modal'
],function(Spinner,$){

    angular.module('pendulum.core',['ui'])
        .factory('pdHttp',function($http){
            return {
                _processPromise:function(promise,config) {
                    promise.always = (function(func) {
                        this.then(func,func);
                        return this;
                    }).bind(promise);
                    promise.always(function(){
                        config.ajaxLoader && (config.ajaxLoader.loading = false);
                    })
                },
                get: function(url,config) {
                    config = $.extend({
                        url:url,
                        method:'GET'
                    },config);
                    config.params = config.data;
                    if(config.ajaxLoader) {
                        config.ajaxLoader.loading = true
                    };
                    var promise = $http(config)
                    this._processPromise(promise,config);
                    return promise;
                }
            };
        })
        .factory('pdServiceResponse',function(){
            return {
                content:function(response){
                    return response.content;
                },
                error:function(response){
                    return response.error;
                }
            }
        })
        .filter('newline', function(){
            return function(text) {
                return text.replace(/\n/g, '<br/>');
            }
        })
        .directive('pdShow',function($timeout,pdCopy){
            var showDefaults = function(){
                return {
                    easing:'linear',
                    duration:0
                }
            }

            var hideDefaults = function(){
                return {
                    easing:'linear',
                    duration:0
                }
            }
            var dir = function(scope, elm, attrs, controller) {

                var showOptions = $.extend(showDefaults(),(scope.$eval(attrs.pdShowOptions) || {}));
                var hideOptions = $.extend(hideDefaults(),(scope.$eval(attrs.pdHideOptions) || {}));

                scope.$watch(attrs.pdShow,function(val){
                    if(val) {
                        elm.show(showOptions);
                    } else {
                        elm.hide(hideOptions);
                    }
                })
            }

            return pdCopy(dir);
        })
        .directive('pdCalendar',['ui.config', '$parse','$timeout', function (uiConfig,$parse,$timeout) {
            uiConfig.uiCalendar = uiConfig.uiCalendar || {};
            //returns calendar
            var directive = {
                require: 'ngModel',
                restrict: 'A',
                link: function(scope, elm, attrs, controller) {
                    var sources = scope.$eval(attrs.ngModel);
                    var tracker = 0;
                    var calendar;

                    /* returns the length of all source arrays plus the length of eventSource itself */
                    var getSources = function () {
                        var equalsTracker = scope.$eval(attrs.equalsTracker);
                        tracker = 0;
                        angular.forEach(sources,function(value,key){
                            if(angular.isArray(value)){
                                tracker += value.length;
                            }
                        });
                        if(angular.isNumber(equalsTracker)){
                            return tracker + sources.length + equalsTracker;
                        }else{
                            return tracker + sources.length;
                        }
                    };

                    /* init the calendar with the correct options */
                    function init() {
                        calendar = elm.html('');
                        var view = calendar.fullCalendar('getView');
                        if(view){
                            view = view.name; //setting the default view to be whatever the current view is. This can be overwritten.
                        }
                        /* If the calendar has options added then render them */
                        var expression,
                            options = {
                                defaultView : view,
                                eventSources: sources
                            };
                        if (attrs.pdCalendar) {
                            expression = scope.$eval(attrs.pdCalendar);
                        } else {
                            expression = {};
                        }
                        angular.extend(options, uiConfig.uiCalendar, expression);
                        calendar.fullCalendar(options);

                        if(attrs.pdCalendarElem) {
                            $timeout(function(){
                                scope.$apply(function(){
                                    $parse(attrs.pdCalendarElem).assign(scope,calendar)
                                })
                            });
                        }
                    }
                    init();

                    function update() {
                        calendar.fullCalendar('refetchEvents');
                    }

                    /* watches all eventSources */
                    scope.$watch(getSources, function( newVal, oldVal ) {
                        update();
                    });
                }
            };


            return directive;
        }])
        .factory('pdGetGrid',function(){
            return function(items){
                return {
                    items:items||[],
                    allSelected:false,
                    selectAllRopd: function(){
                        var allSelected = this.allSelected = !this.allSelected;
                        $.each(this.items,function() {
                            this.selected = allSelected;
                        })
                    },
                    selectRow: function(row,event) {
                        row.selected = !row.selected;
                    },
                    formatDateTime:function(datetime) {
                        var date = new Date(datetime);
                        return (date.getMonth()+1)+'/'+date.getDate()+'/'+date.getFullYear();
                    }
                };
            }
        })
        .factory('pdBlocker',function(){//? require jQuery BlockUI
            var defaults = function() {
                return {
                    message:null,
                    ignoreIfBlocked:true,
                    overlayCSS:{
                        backgroundColor:'#fff',
                        cursor:'default'
                    },
                    baseZ:2e8,
                    css: {
                        width:'0px',
                        height:'0px',
                        left:'50%',
                        right:'50%',
                        margin:0,
                        padding:0,
                        textAlign:'center',
                        color:'#000',
                        opacity:1,
                        cursor:'default'
                    }
                };
            };

            return {
                block:function(elem,config) {
                    config = $.extend(defaults(),config);
                    return $(elem).block(config);
                },
                unblock:function(elem) {
                    return $(elem).unblock()
                },
                blockPage:function(config) {
                    config = $.extend(defaults(),config);
                    return $.blockUI(config);
                },
                unblockPage:function() {
                    return $.unblockUI();
                }
            };
        })
        .factory('pdGetSpinner',function(){ //? require Spin.js
            var defaults = function(){
                return {
                    lines: 13, // The number of lines to draw
                    length: 10, // The length of each line
                    width: 4, // The line thickness
                    radius: 9, // The radius of the inner circle
                    corners: 1, // Corner roundness (0..1)
                    rotate: 0, // The rotation offset
                    direction: 1, // 1: clockwise, -1: counterclockwise
                    color: 'rgba(0,0,0,0.6)', // #rgb or #rrggbb
                    speed: 1, // Rounds per second
                    trail: 60, // Afterglow percentage
                    shadow: false, // Whether to render a shadow
                    hwaccel: false, // Whether to use hardware acceleration
                    className: 'spinner', // The CSS class to assign to the spinner
                    zIndex: 2e9, // The z-index (defaults to 2000000000)
                    top: 'auto', // Top position relative to parent in px
                    left: 'auto' // Left position relative to parent in px
                };
            }
            return function(config) {
                config = $.extend(defaults(),config);
                return new Spinner(config);
            }
        })
        .factory('pdPageBlocker',function($timeout, pdGetSpinner, pdBlocker){
            var spinner = pdGetSpinner();
            var spinnerContainer = $('<div></div>').get(0);
            spinner.spin(spinnerContainer);
            return {
                block:function(){
                    $timeout(function(){
                        pdBlocker.blockPage({
                            message:spinnerContainer
                        })
                    });
                },
                unblock:function(){
                    $timeout(function(){
                        pdBlocker.unblockPage();
                    },500)
                }
            }
        })

        .directive('pdBlock',function($timeout, pdGetSpinner, pdBlocker, pdCopy){
            var directive = {
                restrict: 'AC',
                link:function (scope,element,attrs,controller) {
                    var spinner = pdGetSpinner();
                    scope.$watch(attrs.pdBlock,function(val) {
                        if(val) {
                            pdBlocker.block(element,{
                                onBlock:function(){
                                    spinner.spin(element.get(0));
                                }
                            })
                        }
                        else {
                            $timeout(function(){
                                spinner.stop();
                                pdBlocker.unblock(element);
                            },300)
                        }
                    },true);
                }
            };
            return pdCopy(directive);
        })
        .factory('pdNotify',function($timeout){ //? require pnotify

            var defaults = function(){
                return {
                    title: '',
                    text: '',
                    icon: '',
                    opacity: .7,
                    delay:3000,
                    mouse_reset:false,
                    history: false
                };
            };
            var run = function(config) {
                config = $.extend(defaults(),config);
                return $.pnotify(config);
            }
            var service= {
                success:function(config){
                    config = $.extend({
                        type:'success',
                        icon:'icon-ok-sign',
                        title:'Success',
                        text:'Data successfully saved'
                    },config);
                    return run(config);
                },
                error:function(config){
                    config = $.extend({
                        type:'error',
                        icon:'icon-minus-sign',
                        title:'Error',
                        text:'An error has occurred while trying to save your data'
                    },config);
                    return run(config);
                },
                warning:function(config){
                    config = $.extend({
                        type:'warning',
                        icon:'icon-exclamation-sign',
                        title:'Warning'
                    },config);
                    return run(config);
                },
                handlePromise:function(promise,message) {
                    message = $.extend({success:null,error:null},message);
                    promise.success(function(){
                        service.success({text:message.success});
                    }).error(function(){
                            service.error({text:message.error})
                        })
                }
            };
            return service;
        })
        .directive('pdFocus',function($timeout) {
            return function(scope,element,attrs) {
                scope.$watch(attrs.pdFocus,function(val) {
                    val && $timeout(function(){
                        element.focus();
                    });
                },true);
            }
        })
        .directive('pdOverlay',function($timeout){
            return function(scope,element,attrs) {
                scope.$watch(attrs.pdOverlay,function(val) {
                    val && $timeout(function(){
                        var position = element.offset();
                        $('div').css( { position: "absolute", left: position.left, top: position.top, background: '' } );
                    });
                },true);
            }
        })
        .factory('pdCopy',function() {
            return function(source,destination) {
                return angular.copy(source,destination);
            }
        })
        .directive('pdModalShow',function($timeout,$parse){

            return {
                link:function(scope,element,attrs) {
                    var tinymceElem
                    if(tinymceElem = attrs.tinymce) {
                        tinymceElem = element.find(tinymceElem);
                    }
                    element.on('hide',function(){
                        scope.$apply(function(){$parse(attrs.pdModalShow).assign(scope,false);});
                    })
                    element.on('shown',function(){
                        tinymceElem.each(function(){
                            if($(this).tinymce()) {
                                tinyMCE.execCommand('mceRemoveControl',false,this.id);
                                tinyMCE.execCommand('mceAddControl',false,this.id);
                            }
                        });
                    })
                    scope.$watch(attrs.pdModalShow,function(val) {
                        $timeout(function(){
                            if(val) {
                                element.modal('show');
                            } else {
                                element.modal('hide');
                            }
                        })
                    })
                }
            };

        })
        .directive('pdDatepicker',function($parse){
            return function(scope,element,attrs) {
                element.datepicker({dateFormat:'mm/dd/yy',onSelect:function(dateText){
                    scope.$apply(function(){$parse(attrs.ngModel).assign(scope,dateText);});
                }});
            }
        })
        .factory('jq',function() {
            return jQuery;
        })
        .factory('pdModal',function($rootScope){
            var service = {
                element:null,
                header:null,
                body:null,
                onHide:function(){},
                onShow:function(){},
                buttons:[],
                status:{},
                clear: function() {
                    var _default  = {
                        header:null,
                        body:null,
                        onHide:function(){},
                        onShow:function(){},
                        buttons:[],
                        status:{}
                    }
                    _setParams(_default);
                },

                setParams: function(params, skipClear) {
                    skipClear || this.clear();
                    _setParams(params);
                    if(!$rootScope.$$phase) {
                        $rootScope.$apply();
                    }
                },

                show: function(params) {
                    params && this.setParams(params);
                    this.onShow();
                    this.element.modal('show');
                },

                hide: function(params) {
                    params && this.setParams(params);
                    this.onHide();
                    this.element.modal('hide');
                }
            }
            var _setParams = (function(params) {
                params = params || {};
                var _this = this;
                $.each(params,function(key,val){
                    if(key in _this) {
                        _this[key] = val;
                    }
                })
            }).bind(service);
            return service;
        })
        .factory('pdPubSub',function($timeout,$rootScope){
            return {
                subscribers:{},

                notify: function(message,params) {
                    $.each(this.getSubscribers(message),function(key,updater){
                        updater(params);
                    });
                    $timeout(function(){$rootScope.$apply()});
                    return this;
                },

                subscribe: function(message,updater,thisArg) {
                    thisArg && updater.bind(thisArg);
                    this.getSubscribers(message).push(updater);
                    return this;
                },

                unsubscribe: function(message,updater) {
                    var subscribers = this.getSubscribers(message);
                    $.each(subscribers,function(key,_updater){
                        if(_updater == updater) delete subscribers[key];
                    });
                },

                getSubscribers: function(message) {
                    this.subscribers[message] || (this.subscribers[message]=[]);
                    return this.subscribers[message];
                }
            }
        })
        .factory('pdGetPagination',function(){
            return function(options,extend){
                options = $.extend({
                    loadFunc:function(){},
                    getCountFunc:function(){}
                },options);
                var load     = options.loadFunc;
                var getCount = options.getCountFunc;
                var pagination = {
                    pageSize:10,
                    currentPage:1,
                    pageCount:1,
                    pages:[{number:1}],
                    getState:function(page){
                        var offset = this.offset(page.number);
                        var limit  = this.limit();
                        return {offset:offset,limit:limit,page:page};
                    },
                    applyState:function(state,count){
                        this.currentPage = state.page.number;
                        if(count !== undefined) {
                            this.createPages(count);
                        }
                    },
                    offset: function(currentPage) {
                        return (currentPage-1)*this.pageSize;
                    },
                    limit: function() {
                        return this.pageSize;
                    },
                    atStart: function() {
                        return this.currentPage <= 1;
                    },
                    atEnd: function() {
                        return this.currentPage >= this.pageCount;
                    },
                    atPage: function(page) {
                        return this.currentPage == page.number;
                    },
                    currentState: function() {
                        return this.getState(this.getPageByNumber(this.currentPage));
                    },
                    nextState: function() {
                        if(this.atEnd()) return;
                        return this.getState(this.getPageByNumber(this.currentPage+1));
                    },
                    prevState: function() {
                        if(this.atStart()) return;
                        return this.getState(this.getPageByNumber(this.currentPage-1));
                    },
                    getPageByNumber: function(number) {
                        var page;
                        $.each(this.pages,function(){
                            if(this.number == number) {
                                page = this;
                                return false;
                            }
                        });
                        return page;
                    },
                    createPages: function(count) {
                        var pageCount  = Math.ceil(parseFloat(count)/this.pageSize);
                        this.pageCount = pageCount;
                        this.pages.length = 0;
                        for(var pageNum = 1; pageNum <= pageCount; pageNum++) {
                            this.pages.push(this.createPage(pageNum,pageNum == this.currentPage));
                        }
                    },
                    createPage: function(number,current) {
                        return {number:number,current:current||false}
                    }
                };
                pagination.loadState = function(state) {
                    state && load(state).success(function(data){
                        pagination.applyState(state,getCount(data));
                    });
                };
                pagination.next = function(){
                    pagination.loadState(pagination.nextState());
                };
                pagination.prev = function(){
                    pagination.loadState(pagination.prevState());
                };
                pagination.current = function(){
                    pagination.loadState(pagination.currentState());
                };
                pagination.apply = function(page) {
                    if(pagination.atPage(page)) return;
                    pagination.loadState(pagination.getState(page));
                };
                return $.extend(pagination,extend);
            }

        });
})