$(function () {
    // var customDatasource = {
    //     'auuid': '1',
    //     'name': datasource[0].userprofile.first_name + ' ' + datasource[0].userprofile.last_name,
    //     'title': datasource[0].title,
    //     'children': datasource[0].children,
    //     'userprofile': datasource[0].userprofile,
    // };
    var oc = $('.chart-container').orgchart({
        'data': organogramApi,
        'depth': 2,
        'name': 'name',
        'nodeContent': 'title',
        'nodeID': 'auuid',
        'exportButton': true,
        'exportFilename': 'MyOrgChart',
    });
    $('#organogram-reload').click(function () {
        oc.init({'data':organogramApi});
    });
    //     $('.chart-container').fadeOut(500);
    //     if (typeof (datasource[0].children) != "undefined") {
    //         for (const item of datasource[0].children) {
    //             item.name = item.geography.name;
    //             if (typeof (item.children) != "undefined") {
    //                 if (item.children.length > 0) {
    //                     for (const childItem of item.children) {
    //                         childItem.name = childItem.geography.name;
    //                         if (typeof (childItem.children) != "undefined") {
    //                             if (childItem.children.length > 0) {
    //                                 for (const mdChild of childItem.children) {
    //                                     mdChild.name = mdChild.geography.name;
    //                                     if (typeof (mdChild.children) != "undefined") {
    //                                         if (mdChild.children.length > 0) {
    //                                             for (const grandChild of mdChild.children) {
    //                                                 grandChild.name = grandChild.geography.name;
    //                                             }
    //                                         }
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     var customDatasource = {
    //         'auuid': '1',
    //         'name': datasource[0].geography.name,
    //         'title': datasource[0].title,
    //         'children': datasource[0].children,
    //         'userprofile': datasource[0].userprofile,
    //     };
    //     // $('.chart-geography').orgchart({
    //     //     'data': customDatasource,
    //     //     'depth': 2,
    //     //     'nodeContent': 'title',
    //     //     'nodeID': 'auuid',
    //     //     'exportButton': true,
    //     //     'exportFilename': 'MyOrgChart',
    //     // });
    //     $('.chart-geography').fadeIn(500);
    // });
    // $('#organogram-names').click(function () {
    //     $('.chart-geography').fadeOut(500);
    //     if (typeof (datasource[0].children) != "undefined") {
    //         for (const item of datasource[0].children) {
    //             item.name = item.userprofile.first_name + ' ' + item.userprofile.last_name;
    //             if (typeof (item.children) != "undefined") {
    //                 if (item.children.length > 0) {
    //                     for (const childItem of item.children) {
    //                         childItem.name = childItem.userprofile.first_name + ' ' + childItem.userprofile.last_name;
    //                         if (typeof (childItem.children) != "undefined") {
    //                             if (childItem.children.length > 0) {
    //                                 for (const mdChild of childItem.children) {
    //                                     mdChild.name = mdChild.userprofile.first_name + ' ' + mdChild.userprofile.last_name;
    //                                     if (typeof (mdChild.children) != "undefined") {
    //                                         if (mdChild.children.length > 0) {
    //                                             for (const grandChild of mdChild.children) {
    //                                                 grandChild.name = grandChild.userprofile.first_name + ' ' + grandChild.userprofile.last_name;
    //                                             }
    //                                         }
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     var customDatasource = {
    //         'auuid': '1',
    //         'name': datasource[0].userprofile.first_name + ' ' + datasource[0].userprofile.last_name,
    //         'title': datasource[0].title,
    //         'children': datasource[0].children,
    //         'userprofile': datasource[0].userprofile,
    //     };
    //     // $('.chart-container').orgchart({
    //     //     'data': customDatasource,
    //     //     'depth': 2,
    //     //     'nodeContent': 'title',
    //     //     'nodeID': 'auuid',
    //     //     'exportButton': true,
    //     //     'exportFilename': 'MyOrgChart',
    //     // });
    //     $('.chart-container').fadeIn(500);
    // });
});