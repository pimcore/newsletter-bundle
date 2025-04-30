/**
* This source file is available under the terms of the
* Pimcore Open Core License (POCL)
* Full copyright and license information is available in
* LICENSE.md which is distributed with this source code.
*
*  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.com)
*  @license    Pimcore Open Core License (POCL)
*/

pimcore.registerNS("pimcore.object.classes.data.newsletterConfirmed");
/**
 * @private
 */
pimcore.object.classes.data.newsletterConfirmed = Class.create(pimcore.object.classes.data.data, {

    type: "newsletterConfirmed",

    /**
     * define where this datatype is allowed
     */
    allowIn: {
        object: true,
        objectbrick: true,
        fieldcollection: true,
        localizedfield: true,
        classificationstore : false,
        block: true,
        encryptedField: true
    },

    initialize: function (treeNode, initData) {
        this.type = "newsletterConfirmed";

        if(!initData["name"]) {
            initData = {
                title: t("newsletter_confirmed")
            };
        }

        initData.fieldtype = "newsletterConfirmed";
        initData.datatype = "data";
        initData.name = "newsletterConfirmed";
        initData.noteditable = true;
        treeNode.set("text", "newsletterConfirmed");

        this.initData(initData);

        this.treeNode = treeNode;
    },

    getTypeName: function () {
        return t("newsletter_confirmed");
    },

    getGroup: function () {
        return "crm";
    },

    getIconClass: function () {
        return "pimcore_icon_newsletterConfirmed";
    },

    getLayout: function ($super) {
        $super();

        this.getSpecificPanelItems(this.datax);

        return this.layout;
    },

    getSpecificPanelItems: function (datax, inEncryptedField) {
        const nameField = this.layout.getComponent("standardSettings").getComponent("name");
        nameField.disable();

        const noteditable  = this.layout.getComponent("standardSettings").getComponent("noteditable");
        noteditable.disable();
        return [];
    }
});
