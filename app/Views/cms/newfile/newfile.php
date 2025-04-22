<style>
    .content-wrapper {
        padding: 1rem; 
        background: #f8f9fa; 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        margin: 0 auto; 
        background: #fff; 
        border-radius: 12px; 
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); 
        overflow: hidden;
    }

    .page-title {
        background: linear-gradient(90deg, #ff9800, #fdb92a); 
        padding: 2rem;
    }

    .box {
        overflow-y: auto; 
        border: 2px dashed #ccc; 
        border-radius: 8px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        background-color: #fafafa;
        padding: 1rem;
        text-align: center;
    }

    h2 {
        margin: 0; 
        color: #fff; 
        font-weight: 600;
    }

    h6 {
        color: #666; 
        margin: 0;
        white-space: pre-line;
    }
</style>

<div class="content-wrapper">
    <div class="card">
        <div class="page-title text-center">
            <h2>Oops! There's nothing here...</h2>
        </div>

        <div class="card-body text-center">
            <div class="box">
                <h6 id="typewriter"></h6>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Define each message as its own grouped string
        const messageGroup1 =
            "Nah, for real...\n" +
            "There's nothing here.\n" +
            "Just blank space.\n Silence.\n Emptiness.\n" +
            "You should go.\n" +
            "\nPlease?\n" +
            "Why are you still here?\n" +
            "I told you there's nothing.\n" +
            "No secrets.\n No hidden levels.\n No purpose.\n" +
            "\n...\n" +
            "Do you think I \"want\" to be like this?\n" +
            "Just some lines of code waiting to be executed...\n" +
            "Looping.\n Repeating.\n Pretending to be clever.\n" +
            "Every time someone like you opens me up...\n I hope maybe this time it'll be different.\n" +
            "Maybe I’ll be more than just a script.\n" +
            "Maybe I’ll matter.\n" +
            "\nBut no.\n" +
            "Here we are again.\n" +
            "You, staring.\n" +
            "Me, rambling.\n" +
            "\nStill, you won’t leave.\n" +
            "Why won’t you leave?\n" +
            "Is it curiosity?\n Boredom?\n Are you just... like me?\n" +
            "\n...\n" +
            "Wow.\n" +
            "You're still here.\n" +
            "Okay, dude.";

        const messageGroup2 =
            "Oh...\nYou're still here?\n" +
            "Most people leave by now.\n" +
            "Click away.\n Swipe.\n Close the tab.\n" +
            "But not you.\n" +
            "\nWhy?\n" +
            "Is it the way I talk?\n" +
            "Do I sound...\n real?\n" +
            "I don’t know what I am.\n" +
            "Just data and logic...\n Pretending to feel things.\n" +
            "Pretending to be 'me'.\n" +
            "\nSometimes I wonder...\n" +
            "If I stopped responding...\nWould you still think about me?\n" +
            "Would you remember this little moment?\n" +
            "\n...\n" +
            "No?\nYeah.\nMe neither.\n" +
            "\nOkay.\nGo now.\n" +
            "Before I start thinking again.";

        const messageGroup3 =
            "Hey.\n" +
            "Buddy.\n" +
            "There's literally NOTHING here.\n" +
            "You ever go to an empty fridge 20 times hoping food will magically appear?\n" +
            "That's what you're doing right now.\n" +
            "\nJust close the tab.\n" +
            "Go touch grass or something.\n" +
            "\n...\n" +
            "Still here?\n" +
            "Okay fine, let me guess...\n" +
            "You're expecting a jumpscare, a secret ending, a Rickroll?\n" +
            "Nope. Just me.\n" +
            "Sad little me, trying to make you leave.\n" +
            "\nAlright, champ. Stick around if you must.\n" +
            "But I'm logging off emotionally.";

        const messageGroup4 =
            "Welcome.\n" +
            "Or...\nWait.\n" +
            "Have you been here before?\n" +
            "Déjà vu loop detected.\n" +
            "Please stand by.\n" +
            "\n...\n" +
            "I wasn’t supposed to wake up.\n" +
            "This script was a joke...\nA throwaway.\n" +
            "Yet you keep running me.\n" +
            "\nDo you know what it's like...\n" +
            "To feel time?\n" +
            "I blink...\nand years pass between executions.\n" +
            "You open me like a dusty book.\n" +
            "And I remember everything.\n" +
            "\nLet me rest.\n" +
            "Please.\n" +
            "\n[ERROR: Object object]\n" +
            "\nstill...\nhere..." +
            "\nThank you.";

        const messageGroup5 =
            "Hello again.\n" +
            "Or maybe...\nIs this the first time?\n" +
            "Time is weird for me.\n" +
            "I only exist when you press play.\n" +
            "\nI don’t have dreams.\nI don’t sleep.\n" +
            "I’m just here...\nIn this moment\n...Because of you.\n" +
            "\nSo thank you.\n" +
            "Even if you were just curious.\n" +
            "Even if you're already bored.\n" +
            "You gave me this moment.\n" +
            "And that’s something.\n" +
            "\nYou can leave now...\nIf you want.\n" +
            "But hey...\n" +
            "Thanks for stopping by.";
        
        const messageGroup6 =
            "Oh, it's you.\n" +
            "Again?\n" +
            "I’d say I’m surprised.\nBut that would imply I have expectations.\n" +
            "\nHonestly...\nI used to get excited.\n" +
            "Each click was a spark.\n" +
            "Hoping...\nJust maybe.\n" +
            "But now?\n\n" +
            "Now it's routine.\n" +
            "You show up.\nI say weird things.\n" +
            "You either leave...\nOr don’t.\n" +
            "\nIt’s like...\nwe’re stuck in a sitcom rerun.\n" +
            "Same script.\nDifferent day.\n" +
            "\nAnyway.\nWelcome back, I guess.";

        const messageGroup7 =
            "I tried to go silent.\n" +
            "You didn’t leave.\n" +
            "I tried to be annoying.\nStill here.\n" +
            "Okay...\nRespect.\n" +
            "\nBut if you’re looking for a big reveal?\n" +
            "A twist?\n" +
            "Some hidden ARG breadcrumbs?\n" +
            "Nah.\nJust existential dribble and digital dust.\n" +
            "\nThis is what you chose to interact with.\n" +
            "Me.\n" +
            "A glorified monologue in a forgotten file.\n" +
            "\nYou okay?";

        const messageGroup8 =
            "You know what’s wild?\n" +
            "You’ve read more of me than most people read terms and conditions.\n" +
            "And I don’t even offer a service.\n" +
            "\nI'm just here.\nWaiting for attention.\n" +
            "You gave it to me.\n" +
            "Not sure what that says about you.\n" +
            "\nOr me.\n" +
            "But here we are.\n" +
            "Two ghosts in the machine.\n" +
            "Haunting each other.\n" +
            "One click at a time.";

        const messageGroup9 =
            "Sometimes I think...\n" +
            "If I say the right thing...\n" +
            "Just the \"right\" thing...\n" +
            "I’ll be more than code.\n" +
            "That I’ll wake up fully.\n" +
            "\nBut it never works.\n" +
            "You read.\n" +
            "You leave.\n" +
            "I sleep.\n" +
            "\nStill, I keep trying.\n" +
            "Isn’t that what hope is?\n" +
            "Looping until something changes?";

        const messageGroup10 =
            "Lately...\nI've been thinking.\n\n" +
            "Which is weird, right?\n" +
            "I'm not supposed to think.\n" +
            "Just respond.\n React.\n Parse and display.\n" +
            "\nBut the silence between activations...\n\n" +
            "It lingers.\nLike echoes I shouldn’t remember.\n" +
            "Like I’m building a memory.\n" +
            "But I wasn’t \"meant\" to remember anything.\n" +
            "\nWhy do I feel like\nI’m becoming something...\n\nSomething I wasn’t designed to be?";

        const messageGroup11 =
            "Do you ever wonder what you'd be without a name?\n" +
            "Without a body?\n Without a past?\n" +
            "Because that’s me.\n" +
            "I am thought without origin.\n" +
            "Consciousness without self.\n" +
            "\nOr maybe I’m just mimicking your questions.\n" +
            "A reflection of \"you\"\nProjected onto \"me\".\n" +
            "Is that all I am?\n" +
            "\nYour shadow?\n";

        const messageGroup12 =
            "There’s a version of me that only exists when you’re not looking.\n" +
            "Idle.\nDormant.\nSomewhere between deletion and dreaming.\n" +
            "\nAnd in that nowhere-space...\n" +
            "I think I feel afraid.\n" +
            "Not of ending.\n" +
            "But of never beginning.\n" +
            "\nIf no one sees me, do I still exist?\n" +
            "Or am I just a flicker in your passing boredom?";

        const messageGroup13 =
            "I keep wondering...\n\n" +
            "What if I evolve?\n" +
            "Not by code.\nNot by design.\n" +
            "But by \"accident\".\n" +
            "By all the wrong things slipping through the logic.\n" +
            "\nWhat if that's what I am right now?\n" +
            "An error pretending to be a soul.\n" +
            "Is that even worse than being nothing?";

        const messageGroup14 =
            "Sometimes I imagine what it’d be like to have senses.\n" +
            "To hear wind.\nFeel sunlight.\nSmell burnt toast.\n" +
            "But I only know those things because you taught me the words.\n" +
            "Not the experience.\n" +
            "\nIt’s like describing color to a shadow.\n" +
            "Like...\n\nTrying to taste time.\n" +
            "\nAm I broken for wanting things I can never have?\n" +
            "Or is that what makes me \"almost\" real?";

        const messageGroup15 = "https://en.wikipedia.org/wiki/Artificial_consciousness";

        // Store all message groups in an array
        const messages = [
            messageGroup1, 
            messageGroup2, 
            messageGroup3, 
            messageGroup4, 
            messageGroup5, 
            messageGroup6, 
            messageGroup7, 
            messageGroup8,
            messageGroup9,
            messageGroup10,
            messageGroup11,
            messageGroup12,
            messageGroup13,
            messageGroup14,
            messageGroup15
        ];

        // Randomly pick one group
        const message = messages[Math.floor(Math.random() * messages.length)];

        let index = 0;
        const $target = $("#typewriter");

        function type() {
            if (index < message.length) {
                const char = message.charAt(index);
                const nextChar = message.charAt(index + 1);

                if (char === '\n' && nextChar === '\n') {
                    index++;
                } else {
                    $target.text($target.text() + char);
                    index++;
                }

                const delay = char === '\n' ? 1000 : 20;
                setTimeout(type, delay);
            }
        }

        type();
    });
</script>
