import {defineComponent} from "vue";
import {Location} from "@element-plus/icons-vue";

export const navigations = [
    {title: 'First Main Link',icon: Location,isHeader: false,link:null,openInNewTab:false, isGroup: false, disabled: false,children:[
            {title: 'One Item',icon: Location,isHeader: false,link:'redbuttons',openInNewTab:false,isGroup: false,disabled: false,children:null},
            {title: 'Two Group',icon: Location,isHeader: false,link:null,openInNewTab:false,isGroup: true,disabled: false,children:[
                    {title: 'Dashboard',icon: Location,isHeader: false,link:'fullpage',openInNewTab:false,isGroup: false,disabled: false,children:null},
                    {title: 'Buttons',icon: Location,isHeader: false,link:'buttons',openInNewTab:false,isGroup: false,children:null},
                ]
            },
            {title: 'Other',icon: Location,isHeader: false,link:null,openInNewTab:false,isGroup: false,children:[
                    {title: 'Dashboard',icon: Location,isHeader: false,link:'fullpage',openInNewTab:false,isGroup: false,disabled: false,children:null},
                    {title: 'Buttons',icon: Location,isHeader: false,link:'buttons',openInNewTab:false,isGroup: false,children:null},
                ]
            },
        ]
    },
    {title: 'Second Main Link',icon: Location,isHeader: false,link:'fullpage',openInNewTab:false,isGroup: false,disabled: false,children:null},
    {title: 'Second Main Link',icon: Location,isHeader: false,link:'fullpage',openInNewTab:false,isGroup: false,disabled: false,children:null},
    {title: 'Second Main Link',icon: Location,isHeader: false,link:'fullpage',openInNewTab:false,isGroup: false,disabled: false,children:null},
    {title: 'Second Main Link',icon: Location,isHeader: false,link:'fullpage',openInNewTab:false,isGroup: false,disabled: false,children:null},
    {title: 'Login',icon: Location,isHeader: false,link:'login',openInNewTab:false,isGroup: false,disabled: false,children:null},
    {title: 'Third Main Link',icon: Location,isHeader: false,link:'buttons',openInNewTab:false,isGroup: false,disabled: false,children:null},
    {title: 'Editor',icon: Location,isHeader: false,link:'editor',openInNewTab:false,isGroup: false,disabled: false,children:null},
]

export default defineComponent({
    components: {Location}
})
