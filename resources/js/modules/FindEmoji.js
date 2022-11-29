import openmoji from "openmoji"

const FindEmoji = {
    byAnnotation: (annotation) => {
        const emo = openmoji.openmojis.find(item => {
            return item.annotation.replace(/[-_ ]/g, "").trim() == annotation.replace(/[-_ ]/g, "").trim()
        });

        return (emo !== undefined) ? emo : FindEmoji.byAnnotation('white question mark');
    }
}

export default FindEmoji;

