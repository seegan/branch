function launchApplication(l_url, l_windowName)
{
    if ( typeof launchApplication.winRefs == 'undefined' )
    {
        launchApplication.winRefs = {};
    }
    if ( typeof launchApplication.winRefs[l_windowName] == 'undefined' || launchApplication.winRefs[l_windowName].closed )
    {
        var l_width = screen.availWidth;
        var l_height = screen.availHeight;

        var l_params = 'status=1' +
                       ',resizable=1' +
                       ',scrollbars=1' +
                       ',width=' + l_width +
                       ',height=' + l_height +
                       ',left=0' +
                       ',top=0';

        launchApplication.winRefs[l_windowName] = window.open(l_url, l_windowName, l_params);
        launchApplication.winRefs[l_windowName].moveTo(0,0);
        launchApplication.winRefs[l_windowName].resizeTo(l_width, l_height);
    } else {
        launchApplication.winRefs[l_windowName].focus()
    }
}