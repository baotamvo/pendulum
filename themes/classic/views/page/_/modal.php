<?php

?>

<script>
    function pageModal($scope,wsModal,$element,$timeout) {
        var sc = $scope;
        sc.modal = wsModal;
        sc.modal.element = $element;
        sc.getBodyClass = function(){
            var classMap = {
                info:'alert-info',
                error:'alert-error',
                alert:'alert'
            }
            var klass = '';
            if(sc.modal.status) {
                klass += ' alert';
                $.each(sc.modal.status,function(key,val){
                    if(val) klass += ' '+classMap[key];
                })
            }
            return klass;
        }
    }
</script>

<div ng-controller="pageModal" id="pageModal" class="modal hide" tabindex="-1" role="dialog"
     aria-labelledby="pageModal-label"
     aria-hidden="true" >
    <div class="modal-header" ng-show="modal.header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="pageModal-label">{{modal.header}}</h3>
    </div>
    <div class="modal-body" >
        <div ng-class="getBodyClass()"
             ng-bind-html="modal.body"></div>
    </div>
    <div class="modal-footer">
        <button ng-repeat="button in modal.buttons"
                ng-click="button.click()"
                ng-class="button.klass"
                ws-focus="($index == 0)"
                class='btn'
                data-dismiss="{{button.dismiss && 'modal'}}">
            {{button.text}}
        </button>
    </div>
</div>