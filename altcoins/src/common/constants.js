var server_protocol_domain = 'http://localhost:5005/';
var CONSTANTS = {
    SERVER_ROUTES: {
        Default: server_protocol_domain,
        GET_USER: server_protocol_domain + 'Users/GetUser',
        LOGIN: server_protocol_domain + 'altcoins/#/login/',
        LOGIN_USER: server_protocol_domain + 'Users/LoginUser',
        REGISTER: server_protocol_domain + 'Users/Register',
        REGISTER_USER: server_protocol_domain + 'Users/RegisterUser',
        PORTFOLIO: server_protocol_domain + 'Portfolio',
        GET_PORTFOLIO: server_protocol_domain + 'Portfolio/GetUserPortfolio',
        ADD_COIN: server_protocol_domain + 'Portfolio/AddCoin',
        REFRESH_PORTFOLIO: server_protocol_domain + 'Portfolio/RefreshPortfolio',
        DELETE_PORTFOLIO: server_protocol_domain + 'Portfolio/DeletePortfolio',
        DOWNLOAD_PORTFOLIO: server_protocol_domain + 'Portfolio/DownloadPortfolio'
    },
    GUID_EMPTY: '00000000-0000-0000-0000-000000000000'
};