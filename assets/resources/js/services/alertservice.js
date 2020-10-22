app.service("alertService", function () {
    function setAlert(opc) {
        switch (opc) {
            case 0:
                message = "System error.";
                classes = "alert alert-danger alert-dismissible";
                break;
            case 1:
                message = "Successfully logged.";
                classes = "alert alert-success alert-dismissible";
                break;
            case 2:
                message = "Error logging.";
                classes = "alert alert-danger alert-dismissible";
                break;
            case 3:
                message = "Invalid login and password.";
                classes = "alert alert-warning alert-dismissible";
                break;
            case 4:
                message = "Successfully unlogged.";
                classes = "alert alert-success alert-dismissible";
                break;
            case 5:
                message = "User isn't logged in.";
                classes = "alert alert-danger alert-dismissible";
                break;
            case 6:
                message = "User already logged in.";
                classes = "alert alert-info alert-dismissible";
                break;
            case 7:
                message = "No records.";
                classes = "alert alert-info alert-dismissible";
                break;
            case 8:
                message = "Successfully created.";
                classes = "alert alert-success alert-dismissible";
                break;
            case 9:
                message = "Physical Person not found.";
                classes = "alert alert-warning alert-dismissible";
                break;
            case 10:
                message = "Successfully edited.";
                classes = "alert alert-success alert-dismissible";
                break;
            case 11:
                message = "Successfully deleted.";
                classes = "alert alert-success alert-dismissible";
                break;

            //#region 
            case 12:
                message = "This is a trial version: The data provided for the inclusion test can't be changed.";
                classes = "alert alert-warning alert-dismissible";
                break;
            case 13:
                message = "This is a trial version: The data provided for the edition test can't be changed.";
                classes = "alert alert-warning alert-dismissible";
                break;
            case 14:
                message = "This is a trial version: This record can't be deleted.";
                classes = "alert alert-warning alert-dismissible";
                break;
            //#endregion
        }
        return {
            message: message,
            classes: classes,
        };
    }
    return {
        setAlert: setAlert,
    };
});