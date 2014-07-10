'******************************************************
'**  Video Player Example Application -- Poster Screen
'**  November 2009
'**  Copyright (c) 2009 Roku Inc. All Rights Reserved.
'******************************************************

'******************************************************
'** Perform any startup/initialization stuff prior to 
'** initially showing the screen.  
'******************************************************
Function preShowSeriesPosterScreen(breadA=invalid, breadB=invalid) As Object

    if validateParam(breadA, "roString", "preShowPosterScreen", true) = false return -1
    if validateParam(breadB, "roString", "preShowPosterScreen", true) = false return -1

    port=CreateObject("roMessagePort")
    screen = CreateObject("roPosterScreen")
    screen.SetMessagePort(port)
    if breadA<>invalid and breadB<>invalid then
        screen.SetBreadcrumbText(breadA, breadB)
    end if

    screen.SetListStyle("arced-landscape")
    
    'screen.SetListStyle("arced-portrait")
    'screen.SetListStyle("arced-landscape")
    'screen.SetListStyle("arced-square")
    'screen.SetListStyle("flat-category")
    'screen.SetListStyle("flat-episodic")
    'screen.SetListStyle("rounded-rect-16x9-generic")
    'screen.SetListStyle("flat-episodic-16x9")
    return screen

End Function


'******************************************************
'** Display the home screen and wait for events from 
'** the screen. The screen will show retreiving while
'** we fetch and parse the feeds for the game posters
'******************************************************
Function showSeriesPosterScreen(screen As Object, item As Object) As Integer

    if validateParam(screen, "roPosterScreen", "showPosterScreen") = false return -1
    'if validateParam(category, "roAssociativeArray", "showPosterScreen") = false return -1

    m.curCategory = 0
    m.curShow     = 0
    temp=item.Kids

    series = getSeriesShowForItem(item)
    screen.SetContentList(item.Kids)
    screen.Show()

    while true
        msg = wait(0, screen.GetMessagePort())
        if type(msg) = "roPosterScreenEvent" then
            print "showSeriesPosterScreen | msg = "; msg.GetMessage() " | index = "; msg.GetIndex()
            if msg.isListFocused() then
                m.curCategory = msg.GetIndex()
                m.curShow = 0
                screen.setcontentlist([])
                screen.SetFocusedListItem(m.curShow)
                screen.showmessage("Retrieving")
                screen.SetContentList(series)
                screen.clearmessage()
				print "showSeriesPosterScreen list focused | current category = "; m.curCategory
            else if msg.isListItemSelected() then
                m.curShow = msg.GetIndex()
                items =   screen.getContentList()
                item = items[m.curShow]
                print "showSeriesPosterScreen(2) list item selected | current show = "; m.curShow ; " element="; item.element.getName()
                m.curShow = displaySeriesShowDetailScreen(items, m.curShow)
                'showVideoScreen(item)
                screen.SetFocusedListItem(m.curShow)
                print "list item updated  | new show = "; m.curShow
            else if msg.isScreenClosed() then
                return -1
            end if
        end If
    end while


End Function

'**********************************************************
'** When a poster on the home screen is selected, we call
'** this function passing an associative array with the 
'** data for the selected show.  This data should be 
'** sufficient for the show detail (springboard) to display
'**********************************************************
Function displaySeriesShowDetailScreen(items as Object, showIndex as Integer) As Integer

    'if validateParam(item, "roAssociativeArray", "displayShowDetailScreen") = false return -1

    'shows = getSeriesShowForItem(item)
    screen = preShowDetailScreen("", "")
    showIndex = showDetailScreen(screen, items, showIndex)

    return showIndex
End Function


'**************************************************************
'** Given an roAssociativeArray representing a category node
'** from the category feed tree, return an roArray containing 
'** the names of all of the sub categories in the list. 
'***************************************************************
Function getSeriesShowForItem(item As Object) As Object

    categoryList = CreateObject("roArray", 100, true)
    for each kid in item.Kids
        categoryList.Push(kid.Title)
    next
    return categoryList

End Function


