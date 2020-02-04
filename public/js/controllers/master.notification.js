app.controller('MasterNotificationController', function ($scope) {
    $scope.newMessagesCount = newMessagesCount;
    $scope.unreadInbox = unreadInbox;
    $scope.pendingAttestation = pendingAttestation;
    $scope.pendingMovementAttestation = pendingMovementAttestation;
    $scope.taskNotificationCount = taskNotificationCount;
    $scope.uncompletedTargets = uncompletedTargets;
    $scope.currentRoleFromMaster = (typeof (currentRoleFromMaster) == 'undefined' ? 'Unknown' : currentRoleFromMaster);
});