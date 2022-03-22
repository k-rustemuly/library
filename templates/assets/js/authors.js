"use strict";
$('#authors').DataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": getUrl,
    },
    "columns": [
        { "data": "full_name" }
    ]
} );
