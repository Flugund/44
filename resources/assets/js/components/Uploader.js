module.exports = {

    upload(obj, folder) {
        //alert(document.getElementById("storage_url"))
        if (obj.files.length) {
            var url_obj = document.getElementById("id_storage_url");
            document.getElementById("file_upload_button").disabled = true;
            url_obj.value="";
            document.getElementById('upload_progress').innerHTML = "Uploading: 0%";
            //try {
                var file = obj.files[0];
                var file_address = 'photos/' + folder + '/' + file.name;
                var bucket = new AWS.S3({
                    params: {
                        Bucket: 'reinvent16team44'
                    }
                , signatureVersion: 'v4'
                , computeChecksums: true
                //, region: 'us-east-1'
                , accessKeyId: 'AKIAIEYSAPD7KD5L4MMA'
                , secretAccessKey: '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'
                //, sessionToken: cred["sessionToken"]
                });

                var params = {
                        Key: file_address
                        , Body: file
                        , ACL: 'private'
//                      , SSEKMSKeyId: kmskeyid
//                      , ServerSideEncryption: 'aws:kms'
                    };

                var options = {
                        partSize: 10 * 1024 * 1024,
                        queueSize: 10
                    };

                var res = bucket.upload(params, options).on('httpUploadProgress', function (evt) {document.getElementById('upload_progress').innerHTML = "Uploading: " + Math.round(evt.loaded / evt.total * 100).toString() + "%";}).send(function(err, data) {
                            if (err) {
                              console.log("Error uploading data: ", err);
                              //document.getElementById('upload_progress').innerHTML = "Upload failed";
                              document.getElementById('upload_progress').innerHTML = "Upload failed: " + err;
                              document.getElementById("file_upload_button").disabled = false;
                              return false;
                            } else {
                              console.log("Successfully uploaded data");
                              //alert(file_address);
                              url_obj.value  = file_address;
                              document.getElementById('upload_progress').innerHTML = "Successfully uploaded";
                              document.getElementById("file_upload_button").disabled = false;
                              return true;
                            }
                        });

                //url_obj = document.getElementById("storage_url");
                //alert(url_obj.valueOf)
                return res;
            //} catch(err) {
            //  return false;
            //}
        }
    }
}
