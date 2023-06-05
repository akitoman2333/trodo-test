import moment from 'moment';

export const formatDate = (value, format = 'DD.MM.YYYY') => {
    if (!value)
        return value

    return moment(value).format(format);
}
