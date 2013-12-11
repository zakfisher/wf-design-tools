/* * * * * * * * * * * * * * * * * * * * * * * * *
 * Westfield Tools Global Namespace
 *
 * Author: Zachary Fisher - zfisher@zfidesign.com
 * * * * * * * * * * * * * * * * * * * * * * * * */

WFTools = new function() {
    var t = this;
    var batchRenameStorefronts = new function() {
        var _this = this;
        var select = 'select[name=centre]';
        var viewCentreBtn = 'a.btn.view-centre';
        _this.toggleViewCentreBtnHref = function(e) {
            $(viewCentreBtn).attr('href', '?task=batch-rename-storefronts&centre=' + $(select).val());
        };
        _this.init = function() {
            $('a.not-renamed').text('Not Renamed (' + $('table.not-renamed tbody tr').length + ')');
            $('a.renamed').text('Renamed (' + $('table.renamed tbody tr').length + ')');
            $(document).on('change', select, _this.toggleViewCentreBtnHref);
        };
    };
    var manuallyRenameStorefronts = new function() {
        var _this = this;
        var centreSelect = 'select[name=centre]';
        var retailerSelect = 'select.retailer';
        var viewCentreBtn = 'a.btn.view-centre';
        _this.toggleViewCentreBtnHref = function(e) {
            $(viewCentreBtn).attr('href', '?task=manually-rename-storefronts&centre=' + $(centreSelect).val());
        };
        _this.toggleNewName = function(e) {
            $('form button[type=submit]').prop('disabled', false);
            var option = $(retailerSelect).find('option:selected');
            $('h4.new-filename').find('span.retail-chain-id').text(option.attr('data-retail-chain-id')).siblings('span.retailer-id').text(option.attr('data-retailer-id'));
            $('input[name=new_filename]').val($('h4.new-filename').text());
        };
        _this.submitForm = function() {
            var submitBtn = $('form button[type=submit]');
            if (submitBtn.is('[disabled]')) {
                return false;
            }
            else submitBtn.click();
        };
        _this.init = function() {
            $('a.not-renamed').text('Not Renamed (' + $('table.not-renamed tbody tr').length + ')');
            $('a.renamed').text('Renamed (' + $('table.renamed tbody tr').length + ')');
            $(document).on('change', centreSelect, _this.toggleViewCentreBtnHref);
            $(document).on('change', retailerSelect, _this.toggleNewName);
            $(document).on('keydown', document, function(e) {
                if (e.keyCode == 13) _this.submitForm();
            });
        };
    };
    $(function() {
        var pages = [
            { id: 'batch-rename-storefronts', ns: batchRenameStorefronts },
            { id: 'manually-rename-storefronts', ns: manuallyRenameStorefronts }
        ];
        $(pages).each(function(i, p) {
            if ($('#' + p.id).length > 0) p.ns.init();
        });
    });
};