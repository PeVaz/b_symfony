import {h} from 'preact';
import {findComments} from '../api/api';
import {findRestaurants} from '../api/api';
import {useState, useEffect} from 'preact/hooks';

function Comment({comments}) {
    if (comments !== null && comments.length === 0) {
        return <div className="text-center pt-4">No comments yet</div>;
    }

    if (!comments) {
        return <div className="text-center pt-4">Loading...</div>;
    }

    return (
        <div className="pt-4">
            {comments.map(comment => (
                <div className="shadow border rounded-lg p-3 mb-4">
                    <div className="comment-img mr-3">
                        {!comment.photoFilename ? '' : (
                            <a href={ENV_API_ENDPOINT+'uploads/photos/'+comment.photoFilename} target="_blank">
                                <img src={ENV_API_ENDPOINT+'uploads/photos/'+comment.photoFilename} />
                            </a>
                        )}
                    </div>

                    <h5 className="font-weight-light mt-3 mb-0">{comment.author}</h5>
                    <div className="comment-text">{comment.text}</div>
                </div>
            ))}
        </div>
    );
}

function Restaurant({restaurants}) {
    if (restaurants !== null && restaurants.length === 0) {
        return <div className="text-center pt-4">No restaurants yet</div>;
    }

    if (!restaurants) {
        return <div className="text-center pt-4">Loading...</div>;
    }

    return (
        <div className="pt-4">
            {restaurants.map(restaurant => (
                <div className="shadow border rounded-lg p-3 mb-4">
                    <h5 className="font-weight-light mt-3 mb-0">{restaurant.name}</h5>
                    <div className="restaurant-text">{restaurant.type}</div>
                </div>
            ))}
        </div>
    );
}

export default function Conference({conferences, slug}) {
    const conference = conferences.find(conference => conference.slug === slug);
    const [comments, setComments] = useState(null);
    const [restaurants, setRestaurants] = useState(null);

    useEffect(() => {
        findComments(conference).then(comments => setComments(comments));
        findRestaurants(conference).then(restaurants => setRestaurants(restaurants));
    }, [slug]);

    return (
        <div className="p-3">
            <h4>{conference.city} {conference.year}</h4>
            <Comment comments={comments} />
            <Restaurant restaurants={restaurants} />
        </div>
    );
}