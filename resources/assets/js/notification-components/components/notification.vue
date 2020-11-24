<template>
    <div>
        <li class="nav-item dropdown ">
            <a  class="nav-link dropdown-toggle top_header_a" id="navbarDropdownMenuLinkFirst" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" @click="markNotificationsAsRead()">
                <span class="badge red inlineBlock" v-if="unreadNotifications" >{{unreadNotifications}}</span> <i class="fas fa-bell"></i>
                <span class="d-none d-md-inline-block">Notifications</span>
            </a>
            <div class="dropdown-menu fitContent dropdown-menu-right dropdown_ara_fix" aria-labelledby="navbarDropdownMenuLinkFirst" @click="stopPropagationOnDropdown($event)">
                <div class="topBar" v-if="!expandedSingleIteam">
                    <h6 class=" pl-1">
                        <strong>Latest changes</strong>
                    </h6>
                </div>
                <div class="topBar" v-else>
                    <h6 class=" pl-1">
                        <i class="fas fa-arrow-left mr-1 cusrsorPointer" style="color: #028CDE;" @click="expandedSingleIteamHide($event)"></i>
                        <strong>{{expandedSingleIteam.action_text}}</strong>
                    </h6>
                </div>
                <div v-if="!expandedSingleIteam && !notificationsAndAnnouncement">Loading...</div>
                <ul class="pl-0 animated fadeInRight faster" v-else-if="!expandedSingleIteam">
                    <li class="notification_list_item" v-for="notification in notificationsAndAnnouncement">
                        <div  class="logItem seen read notifications_listing" @click="expandedSingleIteamShow(notification,$event)">
                            <span v-if="!notification.read" class=" badge badge-success" style="display:inline-flex !important">New</span>
                            <span v-else-if="notification.type==='announcements'" class=" badge badge-primary" style="display:inline-flex !important">Announcement</span>
                            <span v-else class=" badge badge-secondary" style="display:inline-flex !important">Notification</span>
                            <div class="notifications_listing_text_block">
                                <strong v-text="notification.action_text+'.'" class="notification_title"></strong>
                                <span v-text="truncateText(notification.body)" class="notification_body d-flex" style="display:flex !important"></span>
                            </div>
                        </div>
                    </li>
                </ul>
                <div v-else class="single_notification_item_text_area animated faster fadeInLeft pl-1" v-text="expandedSingleIteam.body"></div>
            </div>
        </li>
    </div>
</template>
<script>
    import moment from 'moment'
    export default {
        props:['last_read_announcements_at'],
        data() {
            return {
                notificationsAndAnnouncement:null,
                unreadNotifications:0,
                expandedSingleIteam:false,
                notificationsIds:[],
                last_read_announcements_at_updated_prop:null,
            }
        },
        methods: {
            stopPropagationOnDropdown(event){
                event.stopPropagation();
            },
            expandedSingleIteamHide(event){
                event.stopPropagation();
                this.expandedSingleIteam=false
            },
            expandedSingleIteamShow(notification,event){
                event.stopPropagation();
                this.expandedSingleIteam=notification
            },
            totalUnreadNotification() {
                this.unreadNotifications=this.notificationsAndAnnouncement.filter(element=>!element.read).length;
            },
            notificationAndAnnouncementArray(data) {
                let newnotificationsAndAnnouncement = [];
                this.notificationsIds=[];
                Object.keys(data).forEach(element => {
                    data[element].map(e => {
                        e.type = element;
                        if(element==='announcements'){
                            if(!moment(this.last_read_announcements_at_updated_prop).isBefore(moment(e.created_at)))
                            {
                                e.read=true;
                            }
                            else{
                                e.read=false;
                            }
                        }
                        else{
                            this.notificationsIds.push(e.id);
                        }
                        newnotificationsAndAnnouncement.push(e);
                    });
                },this);
                this.notificationsAndAnnouncement=_.sortBy(newnotificationsAndAnnouncement, [function(o) { return o.created_at; }]).reverse();
                this.totalUnreadNotification();
            },
            truncateText(text){
                return _.truncate(text, {
                    'length': 50,
                    'separator': ' '
                });
            },
            markNotificationsAsRead(){
                //mark notification as read
                this.unreadNotifications=0;
                //update notification
                axios.put('/notifications/read', {
                    notifications: this.notificationsIds
                });
                //update announcement
                axios.put('/user/last-read-announcements-at')
                //update last read
                this.last_read_announcements_at_updated_prop=moment().format('YYYY-MM-DD HH:mm:ss');
            },
            periodicalCheckofNotification(){
                setInterval(() => {
                    this.recentNotification();
                },30000)
            },
            recentNotification(){
                let self=this;
                axios
                    .get('/notifications/recent')
                    .then(function (response) {
                        self.notificationAndAnnouncementArray(response.data);
                    })
            },
            setUserName(){
                axios
                    .get('/setusername')

            },
            setUserEmail(){
                axios
                    .get('/setuseremail')
            }
        },
        mounted(){
            this.periodicalCheckofNotification();
            this.last_read_announcements_at_updated_prop=this.last_read_announcements_at;
        },
        created() {
            this.recentNotification();
            /*if(!$cookies.isKey('name')){
                this.setUserEmail();
                this.setUserName();
            }*/
        }
    }
</script>
<style scoped>
    .topBar{
        border-bottom: 1px solid #f1f1f1;
        margin-bottom: 5px;
    }
    .dropdown_ara_fix{
        max-height: 300px;
        overflow: scroll;
        width: 232px  !important;
    }
    .notification_list_item{
        margin: 3px 0px;
    }
    .notifications_listing{
        cursor: pointer
    }
    .single_notification_item_text_area{
        font-size: 12px;
    }
    .notifications_listing_text_block:hover{
        text-decoration: underline;
    }
    .notifications_listing_text_block{
        display: inline;
    }
    .badge:hover{
        text-decoration: none !important;
    }
    .cusrsorPointer{
        cursor:pointer;
    }
</style>