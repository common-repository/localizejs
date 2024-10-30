 !function(a){if(!a.Localize){a.Localize={};for(var e=["translate","untranslate","phrase","initialize","translatePage","setLanguage","getLanguage","detectLanguage","getAvailableLanguages","untranslatePage","bootstrap","prefetch","on","off"],t=0;t<e.length;t++)a.Localize[e[t]]=function(){}}}(window);
 /**
  * Localize Plugin v. 1.3.1
  */
 Localize.on('setLanguage', function(data, event) {
    if (localStorage.getItem('loadedLang') !== data.to) {
        switch (URL_OPTIONS) {
            case "0": // No SEO option
                break;
            case "1": // Subdirectories
                localStorage.setItem('loadedLang', data.to);

                let pathArr = window.location.pathname.split('/');
                let search = window.location.search;
                let lang = pathArr[1];

                if(AVAILABLE_LANGUAGES.includes(lang)) {
                    pathArr.splice(0,2);
                }

                let finalPath = pathArr.join('/');
                finalPath = finalPath + search;

                if (data.to != SOURCE_LANGUAGE) {

                    if(localize_conf.permalink_plain == '1') {

                        window.location.href=setLanguageByQueryParams(data.to);

                    }
                    else {

                        window.location.href=urlFilter('/'+data.to+"/"+finalPath);

                    }

                } else if (data.to === SOURCE_LANGUAGE) {

                    if (localize_conf.permalink_plain == '1') {

                        window.location.href=removeLanguageByQueryParams();

                    } else if (finalPath !== undefined && finalPath != "" && finalPath != "/") {

                        window.location.href=urlFilter("/"+finalPath);

                    } else {
                        window.location.href=urlFilter("/");
                    }

                }
                break;
            case "2": // Subdomains
                localStorage.setItem('loadedLang', data.to);
                if (AVAILABLE_LANGUAGES.includes(data.to)) {

                    let hostname = location.hostname.split('.');
                    let lang = hostname[0];

                    if(AVAILABLE_LANGUAGES.includes(lang)) {
                        hostname.shift();
                    }

                    let hostNameFinal = hostname.join('.');


                    if (data.to == SOURCE_LANGUAGE) {
                        if (localize_conf.permalink_plain == '1') {
                            window.location.href = location.protocol + "//" + hostNameFinal + getAllQueryParams();
                        } else {
                            window.location.href = location.protocol + "//" + hostNameFinal + window.location.pathname;
                        }

                    } else {
                        if (localize_conf.permalink_plain == '1') {
                            window.location.href = location.protocol + "//" + data.to + "." + hostNameFinal + getAllQueryParams();
                        } else {
                            window.location.href = location.protocol + "//" + data.to + "." + hostNameFinal + window.location.pathname;
                        }
                    }

                }
                break;
        }
    }
});

function urlFilter(url) {
    return url.replace(/\/+/g, '/');
}

function setLanguageByQueryParams(lng) {  
    let url = new URL(window.location.href);

    let query_string = url.search;

    let search_params = new URLSearchParams(query_string);
    search_params.set('lang', lng); // always set language even if it's the same

    url.search = search_params.toString();

    return url.toString();

}

function removeLanguageByQueryParams() {  
    
    let url = new URL(window.location.href);

    let query_string = url.search;

    let search_params = new URLSearchParams(query_string);
    
    // new value of "lang" is set here if not exists
    if(search_params.has('lang'))
        search_params.delete('lang');
    
    let searchString = decodeURIComponent(search_params.toString());
    // change the search property of the main url
    url.search = (searchString ? '?' : '' ) + searchString;

    // the new url string
    return url.toString();


}

function getLanguageFromQueryParams() {  
    
    let url = new URL(window.location.href);

    let query_string = url.search;

    let search_params = new URLSearchParams(query_string);
    
    return search_params.get('lang');

}

function getAllQueryParams(){
    let url = new URL(window.location.href);

    return url.search;
}

function addLanguageToLinks() {
    const EXCLUDED_PATHS = ['wp-content', 'wp-admin'];
    // only use if subdirectories seo is set and plain permalinks aren't set, i.e. /es/my-page/ and not ?p=4&lang=es
    if (URL_OPTIONS == '1' && localize_conf.permalink_plain != '1') {
        const links = document.querySelectorAll('a');
        links.forEach((link) => {
            if (link.href) {
                let url = new URL(link.href);
                if (url.hostname === document.domain) {
                    if (url.pathname) {
                        for (let i = 0; i < EXCLUDED_PATHS.length; i++) {
                            if (url.pathname.includes(EXCLUDED_PATHS[i])) {
                                // sometimes other code can add the base url containing the language which shouldn't be here
                                //   so, we go ahead and remove the language if it exists.
                                const lang = findLanguageInPath(url.pathname);
                                if (lang) {
                                    url.pathname = removeLanguageFromPath(url.pathname);
                                    link.href = url.href;
                                }
                                return;
                            }
                        }
                        const lang = findLanguageInPath(url.pathname);

                        if (!lang) {
                            const docUrl = new URL(document.URL);
                            const docLang = findLanguageInPath(docUrl.pathname);
                            if (docLang) {
                                url.pathname = `/${docLang}${url.pathname}`;
                                link.href = url.href;
                            }
                        }
                    }
                }
            }
        });
    }
}

function findLanguageInPath(path) {
    if (path) {
        const pathArray = path.split('/');
        if (AVAILABLE_LANGUAGES.includes(pathArray[1])) {
            return pathArray[1];
        }
    }
    return null;
}

function removeLanguageFromPath(path) {
    if (path) {
        const pathArray = path.split('/');
        pathArray.splice(1,1);
        return pathArray.join('/');
    }
    return path;
}

if (PROJECT_KEY) {
    let params = {
        key: PROJECT_KEY,
        rememberLanguage: (URL_OPTIONS != 1),
        blockedIds: ['wpadminbar'],
        blockedClasses: ['xdebug-error'],
    }
    if (ALLOW_INLINE_BREAK_TAGS) {
       params.allowInlineBreakTags = true;
    }
    if (AUTO_APPROVE) {
       params.autoApprove = true;
    }
    if (RETRANSLATE_ON_NEW_PHRASES) {
       params.retranslateOnNewPhrases = true;
    }
    try {
        if (OVERRIDE_LANG) {
            params.targetLanguage = OVERRIDE_LANG;
        }
    if (ALLOW_INLINE_BREAK_TAGS) {
       params.allowInlineBreakTags = true;
    }
    if (AUTO_APPROVE) {
       params.autoApprove = true;
    }
    if (RETRANSLATE_ON_NEW_PHRASES) {
       params.retranslateOnNewPhrases = true;
    }
    } catch (err) {}

    Localize.initialize(params);

    document.addEventListener("DOMContentLoaded", function(event) {
        addLanguageToLinks();
    });
}
