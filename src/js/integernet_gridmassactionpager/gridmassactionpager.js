/**
 * integer_net GmbH Magento Module
 *
 * @package    DesignBestseller_Amazon
 * @copyright  Copyright (c) 2014 integer_net GmbH (http://www.integer-net.de/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     integer_net GmbH <info@integer-net.de>
 * @author     Viktor Franz <vf@integer-net.de>
 */


/**
 *
 */
var IntegerNet_GridMassActionPager = Class.create();


/**
 *
 * @type {{initialize: Function, updateLoader: Function, restoreLoader: Function, process: Function}}
 */
IntegerNet_GridMassActionPager.prototype = {

    /**
     *
     * @param grid
     * @param massaction
     * @param transport
     */
    initialize: function (grid, massaction, transport) {

        this.grid = grid;
        this.massaction = massaction;
        this.transport = transport;

        this.loadingMaskLoader = $('loading_mask_loader').clone(true);
        this.loadingMaskLoaderImage = $('loading_mask_loader').down().clone();

        this.process(this.transport);
    },

    /**
     *
     * @param message
     */
    updateLoader: function (message) {

        $('loading_mask_loader').update(this.loadingMaskLoaderImage);
        $('loading_mask_loader').insert(new Element('p').update(message));
    },

    /**
     *
     */
    restoreLoader: function () {

        $('loading_mask_loader').replace(this.loadingMaskLoader);
    },

    /**
     *
     * @param transport
     */
    process: function (transport) {

        if (transport.responseJSON && !transport.responseJSON.final) {

            this.updateLoader(transport.responseJSON.message);

            new Ajax.Request(transport.request.url, {
                onComplete: this.process.bind(this)
            });

        } else {

            this.restoreLoader();
            this.massaction.unselectAll();
            this.grid.reload();
        }
    }
};


/**
 *
 * @param grid
 * @param massaction
 * @param transport
 * @constructor
 */
integerNetGridMassActionPager = function (grid, massaction, transport) {
    new IntegerNet_GridMassActionPager(grid, massaction, transport);
};
